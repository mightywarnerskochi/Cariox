@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Add Contact</h2>
        <a href="{{ route('admin.contact.index') }}" class="btn-update" style="text-decoration: none;">Back to Contacts</a>
    </div>

    <form method="POST" action="{{ route('admin.contact.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="section-container">
            <div class="section-header">Basic Information</div>
            <div class="section-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Country <span style="color:red">*</span></label>
                        <input type="text" name="country" class="form-control" value="{{ old('country') }}" required>
                        @error('country') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Country Logo</label>
                        <input type="file" name="country_logo" class="form-control" accept="image/*">
                        @error('country_logo') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Logo Alt Text</label>
                        <input type="text" name="logo_alt" class="form-control" value="{{ old('logo_alt') }}">
                        @error('logo_alt') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Order</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', 1) }}">
                        @error('order') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" class="form-control tinymce" rows="3">{{ old('address') }}</textarea>
                    @error('address') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Map Link</label>
                    <input type="url" name="map_link" class="form-control" value="{{ old('map_link') }}">
                    @error('map_link') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Icon (Small image for layout)</label>
                        <input type="file" name="icon" class="form-control" accept="image/*">
                        @error('icon') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Icon Alt Text</label>
                        <input type="text" name="icon_alt" class="form-control" value="{{ old('icon_alt') }}">
                        @error('icon_alt') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="section-container">
            <div class="section-header">
                <div style="width:100%; display:flex; justify-content:space-between; align-items:center;">
                    <span>Phone Numbers</span>
                    <button type="button" class="btn-add" onclick="addPhone()">+ Add Phone</button>
                </div>
            </div>
            <div class="section-body" id="phoneWrapper">
                @if(old('phone_numbers'))
                    @foreach(old('phone_numbers') as $index => $oldPhone)
                        <div class="append-row">
                            <div class="form-group" style="display: flex; gap: 1rem; align-items: flex-end;">
                                <div style="flex: 1;">
                                    <label>Phone Number</label>
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
                                @if($index > 0)
                                    <button type="button" style="color:red; background:none; border:none; cursor:pointer;" onclick="this.parentElement.parentElement.remove()"><i class="fas fa-times"></i></button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Initial row -->
                    <div class="append-row">
                        <div class="form-group" style="display: flex; gap: 1rem; align-items: flex-end;">
                            <div style="flex: 1;">
                                <label>Phone Number</label>
                                <input type="text" name="phone_numbers[]" class="form-control">
                            </div>
                            <div style="padding-bottom: 10px;">
                                <label style="cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                                    <input type="radio" name="whatsapp_phone" value="new_0"> WhatsApp?
                                </label>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="section-container">
            <div class="section-header">
                <div style="width:100%; display:flex; justify-content:space-between; align-items:center;">
                    <span>Email Addresses</span>
                    <button type="button" class="btn-add" onclick="addEmail()">+ Add Email</button>
                </div>
            </div>
            <div class="section-body" id="emailWrapper">
                @if(old('emails'))
                    @foreach(old('emails') as $index => $oldEmail)
                        <div class="append-row">
                            <div class="form-group" style="display:flex; gap:1rem; align-items:flex-end;">
                                <div style="flex:1;">
                                    <label>Email Address</label>
                                    <input type="email" name="emails[]" class="form-control" value="{{ $oldEmail }}">
                                    @error('emails.' . $index)
                                        <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if($index > 0)
                                    <button type="button" style="color:red; background:none; border:none; cursor:pointer;" onclick="this.parentElement.parentElement.remove()"><i class="fas fa-times"></i></button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Initial row -->
                    <div class="append-row">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="emails[]" class="form-control">
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div style="text-align: right; margin-bottom: 2rem;">
            <a href="{{ route('admin.contact.index') }}" class="btn-update" style="background:#f1f5f9; color:#475569; border-color:#cbd5e1; margin-right: 0.5rem; text-decoration: none;">Cancel</a>
            <button type="submit" class="btn-add" style="padding: 0.75rem 2rem; font-size: 1rem;">Save Contact</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    let phoneIndex = 1;
    function addPhone() {
        const wrapper = document.getElementById('phoneWrapper');
        const row = document.createElement('div');
        row.className = 'append-row';
        row.innerHTML = `
            <div class="form-group" style="display: flex; gap: 1rem; align-items: flex-end; position: relative;">
                <div style="flex: 1;">
                    <label>Phone Number</label>
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
            <div class="form-group" style="display:flex; gap:1rem; align-items:flex-end;">
                <div style="flex:1;">
                    <label>Email Address</label>
                    <input type="email" name="emails[]" class="form-control">
                </div>
                <button type="button" style="color:red; background:none; border:none; cursor:pointer;" onclick="this.parentElement.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>
        `;
        wrapper.appendChild(row);
    }
</script>
@endpush
@endsection
