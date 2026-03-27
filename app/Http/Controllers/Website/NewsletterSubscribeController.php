<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterSubscribeController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = strtolower(trim($validated['email']));

        // Handle soft-deleted rows as well, otherwise unique index may fail.
        $existing = Newsletter::withTrashed()->where('email', $email)->first();
        if ($existing) {
            if (method_exists($existing, 'trashed') && $existing->trashed()) {
                $existing->restore();
            }

            return redirect()->route('thank-you');
        }

        Newsletter::create([
            'email' => $email,
        ]);

        return redirect()->route('thank-you');
    }
}

