@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Edit Contact: {{ $contact->country }}</h2>
        <a href="{{ route('admin.contact.index') }}" class="btn-update" style="text-decoration: none;">Back to Contacts</a>
    </div>

    <form method="POST" action="{{ route('admin.contact.update', $contact->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="section-container">
            <div class="section-header">Basic Information</div>
            <div class="section-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Country <span style="color:red">*</span></label>
                        <input type="text" name="country" class="form-control" value="{{ old('country', $contact->country) }}" required>
                        @error('country') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Country Logo</label>
                        <input type="file" name="country_logo" class="form-control" accept="image/*">
                        @error('country_logo') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                        @if($contact->country_logo)
                            <div style="margin-top: 0.5rem;"><img src="{{ Storage::url($contact->country_logo) }}" height="50"></div>
                        @endif
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Logo Alt Text</label>
                        <input type="text" name="logo_alt" class="form-control" value="{{ old('logo_alt', $contact->logo_alt) }}">
                        @error('logo_alt') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Order</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', $contact->order) }}">
                        @error('order') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" class="form-control tinymce" rows="3">{{ old('address', $contact->address) }}</textarea>
                    @error('address') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Map Link</label>
                    <input type="url" name="map_link" class="form-control" value="{{ old('map_link', $contact->map_link) }}">
                    @error('map_link') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Icon</label>
                        <input type="file" name="icon" class="form-control" accept="image/*">
                        @error('icon') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                        @if($contact->icon)
                            <div style="margin-top: 0.5rem;"><img src="{{ Storage::url($contact->icon) }}" height="30"></div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Icon Alt Text</label>
                        <input type="text" name="icon_alt" class="form-control" value="{{ old('icon_alt', $contact->icon_alt) }}">
                        @error('icon_alt') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="section-container">
            <div class="section-header">
                <div style="width:100%; display:flex; justify-content:space-between; align-items:center;">
                    <span>Existing Phone Numbers</span>
                    <button type="button" class="btn-add" onclick="addPhone()">+ Add New Phone</button>
                </div>
            </div>
            <div class="section-body" id="phoneWrapper">
                @foreach($contact->phones as $phone)
                    <div class="append-row existing-item">
                        <div class="form-group" style="display: flex; gap: 1rem; align-items: flex-end;">
                            <div style="flex: 1;">
                                <label>Phone Number</label>
                                <input type="text" name="existing_phones[{{ $phone->id }}][number]" class="form-control" value="{{ old("existing_phones.{$phone->id}.number", $phone->phone_number) }}">
                                @error("existing_phones.{$phone->id}.number")
                                    <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="padding-bottom: 10px;">
                                <label style="cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                                    <input type="radio" name="whatsapp_phone" value="existing_{{ $phone->id }}" {{ old('whatsapp_phone', $phone->is_whatsapp ? 'existing_'.$phone->id : '') == 'existing_'.$phone->id ? 'checked' : '' }}> WhatsApp?
                                </label>
                            </div>
                            <div style="padding-bottom: 10px;">
                                <label style="cursor: pointer; color:red; display: flex; align-items: center; gap: 0.3rem;">
                                    <input type="checkbox" name="delete_phones[]" value="{{ $phone->id }}" class="delete-checkbox"> Delete
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                @if(old('phone_numbers'))
                    @foreach(old('phone_numbers') as $index => $oldPhone)
                        <div class="append-row">
                            <div class="form-group" style="display: flex; gap: 1rem; align-items: flex-end; border-top: 1px dashed #ccc; padding-top: 10px; margin-top: 10px;">
                                <div style="flex: 1;">
                                    <label>New Phone Number</label>
                                    <input type="text" name="phone_numbers[]" class="form-control" value="{{ $oldPhone }}">
                                    @error('phone_numbers.' . $index)
                                        <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div style="padding-bottom: 10px;">
                                    <label style="cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                                        <input type="radio" name="whatsapp_phone" value="new_{{ $index }}" {{ old('whatsapp_phone') == 'new_'.$index ? 'checked' : '' }}> WhatsApp?
                                    </label>
                                </div>
                                <button type="button" style="color:red; background:none; border:none; cursor:pointer;" onclick="this.parentElement.parentElement.remove()"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="section-container">
            <div class="section-header">
                <div style="width:100%; display:flex; justify-content:space-between; align-items:center;">
                    <span>Existing Email Addresses</span>
                    <button type="button" class="btn-add" onclick="addEmail()">+ Add New Email</button>
                </div>
            </div>
            <div class="section-body" id="emailWrapper">
                @foreach($contact->emails as $email)
                    <div class="append-row existing-item">
                        <div class="form-group" style="display:flex; gap:1rem; align-items:flex-end;">
                            <div style="flex:1;">
                                <label>Email Address</label>
                                <input type="email" name="existing_emails[{{ $email->id }}][email]" class="form-control" value="{{ old("existing_emails.{$email->id}.email", $email->email) }}">
                                @error("existing_emails.{$email->id}.email")
                                    <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="padding-bottom: 10px;">
                                <label style="cursor: pointer; color:red; display: flex; align-items: center; gap: 0.3rem;">
                                    <input type="checkbox" name="delete_emails[]" value="{{ $email->id }}" class="delete-checkbox"> Delete
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                @if(old('emails'))
                    @foreach(old('emails') as $index => $oldEmail)
                        <div class="append-row">
                            <div class="form-group" style="display:flex; gap:1rem; align-items:flex-end; border-top: 1px dashed #ccc; padding-top: 10px; margin-top: 10px;">
                                <div style="flex:1;">
                                    <label>New Email Address</label>
                                    <input type="email" name="emails[]" class="form-control" value="{{ $oldEmail }}">
                                    @error('emails.' . $index)
                                        <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="button" style="color:red; background:none; border:none; cursor:pointer;" onclick="this.parentElement.parentElement.remove()"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div style="text-align: right; margin-bottom: 2rem;">
            <a href="{{ route('admin.contact.index') }}" class="btn-update" style="background:#f1f5f9; color:#475569; border-color:#cbd5e1; margin-right: 0.5rem; text-decoration: none;">Cancel</a>
            <button type="submit" class="btn-add" style="padding: 0.75rem 2rem; font-size: 1rem;">Update Contact</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    let phoneIndex = 100; // Offset for new indices
    function addPhone() {
        const wrapper = document.getElementById('phoneWrapper');
        const row = document.createElement('div');
        row.className = 'append-row';
        row.innerHTML = `
            <div class="form-group" style="display: flex; gap: 1rem; align-items: flex-end; border-top: 1px dashed #ccc; padding-top: 10px; margin-top: 10px;">
                <div style="flex: 1;">
                    <label>New Phone Number</label>
                    <input type="text" name="phone_numbers[]" class="form-control">
                </div>
                <div style="padding-bottom: 10px;">
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                        <input type="radio" name="whatsapp_phone" value="new_${phoneIndex}"> WhatsApp?
                    </label>
                </div>
                <button type="button" style="color:red; background:none; border:none; cursor:pointer;" onclick="this.parentElement.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>
        `;
        wrapper.appendChild(row);
        phoneIndex++;
    }

    function addEmail() {
        const wrapper = document.getElementById('emailWrapper');
        const row = document.createElement('div');
        row.className = 'append-row';
        row.innerHTML = `
            <div class="form-group" style="display:flex; gap:1rem; align-items:flex-end; border-top: 1px dashed #ccc; padding-top: 10px; margin-top: 10px;">
                <div style="flex:1;">
                    <label>New Email Address</label>
                    <input type="email" name="emails[]" class="form-control">
                </div>
                <button type="button" style="color:red; background:none; border:none; cursor:pointer;" onclick="this.parentElement.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>
        `;
        wrapper.appendChild(row);
    }

    // Visual feedback for deletion
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('delete-checkbox')) {
            const item = e.target.closest('.existing-item');
            if (e.target.checked) {
                if (item) {
                    item.style.opacity = '0.5';
                    item.style.filter = 'grayscale(1)';
                    item.style.border = '1px solid red';
                    item.style.background = '#fff5f5';
                }
            } else {
                if (item) {
                    item.style.opacity = '1';
                    item.style.filter = 'none';
                    item.style.border = 'none';
                    item.style.background = 'transparent';
                }
            }
        }
    });
</script>
@endpush
@endsection
