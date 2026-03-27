<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;
use App\Models\ContactPhone;
use App\Models\ContactEmail;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('order')->get();
        return view('admin.contact.index', compact('contacts'));
    }

    public function create()
    {
        return view('admin.contact.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'country' => 'required|string|max:255',
            'country_logo' => 'nullable|image|max:2048',
            'icon' => 'nullable|image|max:2048',
            'phone_numbers.*' => 'nullable|distinct',
        ], [
            'phone_numbers.*.distinct' => 'Phone numbers must be unique within the same address',
        ]);

        $countryLogoPath = $request->hasFile('country_logo') ? $request->file('country_logo')->store('contacts/logos', 'public') : null;
        $iconPath = $request->hasFile('icon') ? $request->file('icon')->store('contacts/icons', 'public') : null;

        $contact = Contact::create([
            'country' => $request->country,
            'country_logo' => $countryLogoPath,
            'logo_alt' => $request->logo_alt,
            'address' => $request->address,
            'map_link' => $request->map_link,
            'icon' => $iconPath,
            'icon_alt' => $request->icon_alt,
            'order' => $request->order ?? (Contact::max('order') + 1),
            'status' => $request->status ?? 1,
        ]);

        if ($request->has('phone_numbers')) {
            foreach ($request->phone_numbers as $index => $phone) {
                if (!empty($phone)) {
                    ContactPhone::create([
                        'contact_id' => $contact->id,
                        'phone_number' => $phone,
                        'is_whatsapp' => ($request->whatsapp_phone == "new_$index") ? 1 : 0,
                        'order' => $index + 1
                    ]);
                }
            }
        }

        if ($request->has('emails')) {
            foreach ($request->emails as $index => $email) {
                if (!empty($email)) {
                    ContactEmail::create([
                        'contact_id' => $contact->id,
                        'email' => $email,
                        'order' => $index + 1
                    ]);
                }
            }
        }

        return redirect()->route('admin.contact.index')->with('success', 'Contact created successfully.');
    }

    public function edit($id)
    {
        $contact = Contact::with(['phones', 'emails'])->findOrFail($id);
        return view('admin.contact.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        if ($request->has('order') && !$request->has('country')) {
            $request->validate(['order' => 'required|integer|min:1']);

            if ($request->order != $contact->order) {
                $newOrder = $request->order;
                $currentOrder = $contact->order;

                if ($newOrder < $currentOrder) {
                    Contact::where('order', '>=', $newOrder)
                        ->where('order', '<', $currentOrder)
                        ->increment('order');
                }
                elseif ($newOrder > $currentOrder) {
                    Contact::where('order', '<=', $newOrder)
                        ->where('order', '>', $currentOrder)
                        ->decrement('order');
                }
                $contact->order = $newOrder;
                $contact->save();
            }
            return back()->with('success', 'Contact order updated successfully.');
        }

        $request->validate([
            'country' => 'required|string|max:255',
            'country_logo' => 'nullable|image|max:2048',
            'icon' => 'nullable|image|max:2048',
            'order' => 'nullable|integer|min:1',
            'phone_numbers.*' => 'nullable|distinct',
            'existing_phones.*.number' => 'nullable|distinct',
        ], [
            'phone_numbers.*.distinct' => 'Phone numbers must be unique within the same address',
            'existing_phones.*.number.distinct' => 'Phone numbers must be unique within the same address',
        ]);

        // Cross-validation for uniqueness between new and existing items
        $allPhones = collect();
        if ($request->has('existing_phones')) {
            foreach ($request->existing_phones as $fid => $fData) {
                if (!empty($fData['number'])) $allPhones->push($fData['number']);
            }
        }
        if ($request->has('phone_numbers')) {
            foreach ($request->phone_numbers as $phone) {
                if (!empty($phone)) $allPhones->push($phone);
            }
        }
        if ($allPhones->duplicates()->isNotEmpty()) {
            return back()->withErrors(['phone_numbers' => 'Phone numbers must be unique within the same address'])->withInput();
        }

        if ($request->hasFile('country_logo')) {
            if ($contact->country_logo && Storage::disk('public')->exists($contact->country_logo)) {
                Storage::disk('public')->delete($contact->country_logo);
            }
            $contact->country_logo = $request->file('country_logo')->store('contacts/logos', 'public');
        }

        if ($request->hasFile('icon')) {
            if ($contact->icon && Storage::disk('public')->exists($contact->icon)) {
                Storage::disk('public')->delete($contact->icon);
            }
            $contact->icon = $request->file('icon')->store('contacts/icons', 'public');
        }

        // Handle order change in full update
        if ($request->has('order') && $request->order != $contact->order) {
            $newOrder = $request->order;
            $currentOrder = $contact->order;

            if ($newOrder < $currentOrder) {
                Contact::where('order', '>=', $newOrder)
                    ->where('order', '<', $currentOrder)
                    ->increment('order');
            }
            elseif ($newOrder > $currentOrder) {
                Contact::where('order', '<=', $newOrder)
                    ->where('order', '>', $currentOrder)
                    ->decrement('order');
            }
            $contact->order = $newOrder;
        }

        $contact->update([
            'country' => $request->country,
            'logo_alt' => $request->logo_alt,
            'address' => $request->address,
            'map_link' => $request->map_link,
            'icon_alt' => $request->icon_alt,
            'status' => $request->status ?? $contact->status,
        ]);
        $contact->order = $request->order ?? $contact->order;
        $contact->save();

        // Delete multiple children if requested
        if ($request->has('delete_phones')) {
            ContactPhone::whereIn('id', $request->delete_phones)->delete();
        }
        if ($request->has('delete_emails')) {
            ContactEmail::whereIn('id', $request->delete_emails)->delete();
        }

        $whatsappSource = $request->whatsapp_phone; // e.g., "existing_2" or "new_100"

        // Update existing children
        if ($request->has('existing_phones')) {
            foreach ($request->existing_phones as $fid => $fData) {
                ContactPhone::where('id', $fid)->update([
                    'phone_number' => $fData['number'],
                    'is_whatsapp' => ($whatsappSource == "existing_$fid") ? 1 : 0
                ]);
            }
        }
        if ($request->has('existing_emails')) {
            foreach ($request->existing_emails as $fid => $fData) {
                ContactEmail::where('id', $fid)->update(['email' => $fData['email']]);
            }
        }

        // Store new ones
        if ($request->has('phone_numbers')) {
            foreach ($request->phone_numbers as $index => $phone) {
                if (!empty($phone)) {
                    ContactPhone::create([
                        'contact_id' => $contact->id,
                        'phone_number' => $phone,
                        'is_whatsapp' => ($whatsappSource == "new_$index") ? 1 : 0,
                        'order' => $index + 1
                    ]);
                }
            }
        }

        if ($request->has('emails')) {
            foreach ($request->emails as $index => $email) {
                if (!empty($email)) {
                    ContactEmail::create([
                        'contact_id' => $contact->id,
                        'email' => $email,
                        'order' => $index + 1
                    ]);
                }
            }
        }

        return redirect()->route('admin.contact.index')->with('success', 'Contact updated successfully.');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        // We could delete files too if it was a hard delete
        $contact->delete(); // This triggers soft delete
        return back()->with('success', 'Contact moved to trash.');
    }

    public function toggleStatus($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->status = !$contact->status;
        $contact->save();
        return back()->with('success', 'Status updated.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            Contact::whereIn('id', $ids)->delete();
            return back()->with('success', 'Selected contacts moved to trash.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }

    public function bulkToggleStatus(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $contacts = Contact::whereIn('id', $ids)->get();
            foreach ($contacts as $contact) {
                $contact->status = !$contact->status;
                $contact->save();
            }
            return back()->with('success', 'Selected contacts status toggled.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }
}
