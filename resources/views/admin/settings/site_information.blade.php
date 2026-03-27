@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Site Information</h2>
    </div>



    <form action="{{ route('admin.settings.info.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Company & Contact Info -->
        <div class="section-container">
            <div class="section-header">Company Details</div>
            <div class="section-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Company Name</label>
                        <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $settings->company_name) }}">
                    </div>
                    <div class="form-group">
                        <label>Official Email</label>
                        <input type="email" name="official_email" class="form-control" value="{{ old('official_email', $settings->official_email) }}">
                    </div>
                    <div class="form-group">
                        <label>Official Phone Number</label>
                        <input type="text" name="official_phone" class="form-control" value="{{ old('official_phone', $settings->official_phone) }}" placeholder="+971 6 749 4981">
                    </div>
                    <div class="form-group">
                        <label>Official WhatsApp Number</label>
                        <input type="text" name="official_whatsapp" class="form-control" value="{{ old('official_whatsapp', $settings->official_whatsapp) }}" placeholder="+971 54 586 4310">
                    </div>
                </div>
            </div>
        </div>

        <!-- Logos & Favicon -->
        <div class="section-container">
            <div class="section-header">Identity & Logos</div>
            <div class="section-body">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
                    <!-- Header Logo -->
                    <div class="form-group">
                        <label>Company Logo (Header)</label>
                        <input type="file" name="logo" class="form-control" accept="image/*">
                        @error('logo') <span class="error-text d-block" style="color:red; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</span> @enderror
                        @if($settings->logo)
                            <div id="logo-preview-container" style="display: flex; align-items: flex-end; gap: 10px; margin-top: 0.5rem;">
                                <img src="{{ Storage::url($settings->logo) }}" style="max-height: 50px; display: block; background: #eee; padding: 5px;">
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeImage('logo', 'logo-preview-container')" style="font-size: 0.75rem; padding: 0.2rem 0.5rem; background: #ef4444; color: white; border: none; border-radius: 0.25rem; cursor: pointer;"><i class="fas fa-trash"></i> Remove</button>
                            </div>
                        @endif
                        <div style="margin-top: 0.5rem;">
                            <label style="font-size: 0.75rem; color: #64748b;">Logo Alt Text</label>
                            <input type="text" name="logo_alt_text" class="form-control" value="{{ old('logo_alt_text', $settings->logo_alt_text) }}">
                        </div>
                    </div>

                    <!-- Footer Logo -->
                    <div class="form-group">
                        <label>Footer Logo</label>
                        <input type="file" name="footer_logo" class="form-control" accept="image/*">
                        @if($settings->footer_logo)
                            <div id="footer_logo-preview-container" style="display: flex; align-items: flex-end; gap: 10px; margin-top: 0.5rem;">
                                <img src="{{ Storage::url($settings->footer_logo) }}" style="max-height: 50px; display: block; background: #333; padding: 5px;">
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeImage('footer_logo', 'footer_logo-preview-container')" style="font-size: 0.75rem; padding: 0.2rem 0.5rem; background: #ef4444; color: white; border: none; border-radius: 0.25rem; cursor: pointer;"><i class="fas fa-trash"></i> Remove</button>
                            </div>
                        @endif
                        <div style="margin-top: 0.5rem;">
                            <label style="font-size: 0.75rem; color: #64748b;">Footer Logo Alt Text</label>
                            <input type="text" name="footer_logo_alt_text" class="form-control" value="{{ old('footer_logo_alt_text', $settings->footer_logo_alt_text) }}">
                        </div>
                    </div>

                    <!-- Favicon -->
                    <div class="form-group">
                        <label>Favicon</label>
                        <input type="file" name="favicon" class="form-control" accept="image/x-icon,image/png">
                        @error('favicon') <span class="error-text d-block" style="color:red; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</span> @enderror
                        @if($settings->favicon)
                            <div id="favicon-preview-container" style="display: flex; align-items: flex-end; gap: 10px; margin-top: 0.5rem;">
                                <img src="{{ Storage::url($settings->favicon) }}" style="width: 32px; height: 32px; display: block;">
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeImage('favicon', 'favicon-preview-container')" style="font-size: 0.75rem; padding: 0.2rem 0.5rem; background: #ef4444; color: white; border: none; border-radius: 0.25rem; cursor: pointer;"><i class="fas fa-trash"></i> Remove</button>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group" style="margin-top: 1rem;">
                    <label>Footer Logo Description</label>
                    <textarea name="footer_logo_description" class="form-control tinymce" rows="3">{{ old('footer_logo_description', $settings->footer_logo_description) }}</textarea>
                </div>

                <div class="form-group" style="margin-top: 1.5rem;">
                    <label>Copyright</label>
                    <textarea name="copyright" class="form-control tinymce" rows="4" placeholder="&copy; {{ date('Y') }}. Company Name. All Rights Reserved">{{ old('copyright', $settings->copyright) }}</textarea>
                    @error('copyright') <span style="color:red; font-size: 0.8rem; display: block; margin-top: 0.25rem;">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Social Media -->
        <div class="section-container">
            <div class="section-header">Social Media Links</div>
            <div class="section-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label><i class="fab fa-facebook" style="color: #1877F2;"></i> Facebook Link</label>
                        <input type="url" name="facebook_link" class="form-control" value="{{ old('facebook_link', $settings->facebook_link) }}" placeholder="https://facebook.com/yourpage">
                        @error('facebook_link')
                            <span style="color:red; font-size: 0.8rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label><i class="fab fa-instagram" style="color: #E4405F;"></i> Instagram Link</label>
                        <input type="url" name="instagram_link" class="form-control" value="{{ old('instagram_link', $settings->instagram_link) }}" placeholder="https://instagram.com/yourhandle">
                        @error('instagram_link')
                            <span style="color:red; font-size: 0.8rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label><i class="fab fa-linkedin" style="color: #0A66C2;"></i> LinkedIn Link</label>
                        <input type="url" name="linkedin_link" class="form-control" value="{{ old('linkedin_link', $settings->linkedin_link) }}" placeholder="https://linkedin.com/in/yourprofile">
                        @error('linkedin_link')
                            <span style="color:red; font-size: 0.8rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label><i class="fab fa-twitter" style="color: #1DA1F2;"></i> Twitter Link</label>
                        <input type="url" name="twitter_link" class="form-control" value="{{ old('twitter_link', $settings->twitter_link) }}" placeholder="https://twitter.com/yourhandle">
                        @error('twitter_link')
                            <span style="color:red; font-size: 0.8rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label><i class="fab fa-pinterest" style="color: #BD081C;"></i> Pinterest Link</label>
                        <input type="url" name="pinterest_link" class="form-control" value="{{ old('pinterest_link', $settings->pinterest_link) }}" placeholder="https://pinterest.com/yourprofile">
                        @error('pinterest_link')
                            <span style="color:red; font-size: 0.8rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label><i class="fab fa-youtube" style="color: #FF0000;"></i> YouTube Link</label>
                        <input type="url" name="youtube_link" class="form-control" value="{{ old('youtube_link', $settings->youtube_link) }}" placeholder="https://youtube.com/c/yourchannel">
                        @error('youtube_link')
                            <span style="color:red; font-size: 0.8rem;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Legal/Policy -->
        <div class="section-container">
            <div class="section-header">Legal & Policies</div>
            <div class="section-body">
                <div class="form-group">
                    <label>Terms and Conditions</label>
                    <textarea name="terms_conditions" id="terms_conditions" class="form-control tinymce">{{ old('terms_conditions', $settings->terms_conditions) }}</textarea>
                </div>
                <div class="form-group" style="margin-top: 2rem;">
                    <label>Privacy Policy</label>
                    <textarea name="privacy_policy" id="privacy_policy" class="form-control tinymce">{{ old('privacy_policy', $settings->privacy_policy) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Extra SEO & Tracking -->
        <div class="section-container">
            <div class="section-header">Extra SEO & Tracking</div>
            <div class="section-body">
                <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 2rem;">
                    Google Tag Manager and other tracking/SEO scripts. These are injected site-wide in the front-end layout.
                </p>

                <div class="form-group">
                    <label style="font-weight: 600; display: block; margin-bottom: 0.5rem;">Google Tag Manager container ID(s)</label>
                    <textarea name="gtm_ids" class="form-control" rows="3" placeholder="One per line, e.g.&#10;GTM-P0GFW4PT">{{ old('gtm_ids', $settings->gtm_ids) }}</textarea>
                    <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.5rem;">
                        Enter one GTM container ID per line (e.g. GTM-XXXXXXX). The standard GTM script and noscript iframe will be added automatically.
                    </p>
                </div>

                <div class="form-group" style="margin-top: 2rem;">
                    <label style="font-weight: 600; display: block; margin-bottom: 0.5rem;">Custom head scripts</label>
                    <textarea name="custom_head_scripts" class="form-control" rows="4" placeholder="Paste any <script>, <meta>, or other HTML to inject in <head>">{{ old('custom_head_scripts', $settings->custom_head_scripts) }}</textarea>
                    <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.5rem;">
                        Optional. Raw HTML injected before &lt;/head&gt;. Use for analytics, verification tags, etc.
                    </p>
                </div>

                <div class="form-group" style="margin-top: 2rem;">
                    <label style="font-weight: 600; display: block; margin-bottom: 0.5rem;">Custom body scripts</label>
                    <textarea name="custom_body_scripts" class="form-control" rows="4" placeholder="Paste any <noscript>, <script>, or other HTML to inject at start of <body>">{{ old('custom_body_scripts', $settings->custom_body_scripts) }}</textarea>
                    <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.5rem;">
                        Optional. Raw HTML injected right after &lt;body&gt;. Use for GTM noscript fallbacks or other body-level snippets.
                    </p>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 3rem; text-align: right;">
            <button type="submit" class="btn-submit" style="padding: 1rem 3rem; font-size: 1rem;">Save All Site Settings</button>
        </div>
    </form>
</div>
@stop

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Auto-add https:// for URL inputs if omitted
        document.querySelectorAll('input[type="url"]').forEach(function(input) {
            input.addEventListener('blur', function() {
                let val = this.value.trim();
                if (val && !/^https?:\/\//i.test(val)) {
                    this.value = 'https://' + val;
                }
            });
        });
    });

    window.removeImage = function(field, containerId) {
        if (confirm('Are you sure you want to remove this image?')) {
            fetch('{{ route("admin.settings.info.remove_image") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ field: field })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const container = document.getElementById(containerId);
                    if (container) {
                        container.style.display = 'none';
                    }
                    const input = document.querySelector(`input[name="${field}"]`);
                    if (input) {
                        input.value = '';
                    }
                } else {
                    alert(data.message || 'Failed to remove image.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while removing the image.');
            });
        }
    };
</script>
@endpush
