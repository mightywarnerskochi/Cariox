<div class="modal fade siteEnquiryForm" id="downloadBrochureForm" aria-hidden="true" aria-labelledby="downloadBrochureFormLabel"
    tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                id="downloadBrochureFormClose">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                    <path d="M1.25 15.3933L15.3933 1.25M15.3933 15.3933L1.25 1.25" stroke="black" stroke-width="2.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <div class="modal-body p-0">
                <div class="modal-body-content">
                    <div class="modal-form">
                        <div class="modal-form__bg modal-form__bg--top"></div>
                        <div class="modal-form__bg modal-form__bg--bottom"></div>

                        <p class="title" id="downloadBrochureFormLabel" style="margin-bottom:5px;">Complete Form to Download</p>
                        <p style="font-size: 14px; color: #666; margin-bottom: 20px;">Fill up the form and download brochure</p>

                        <form id="downloadBrochureFormValidation" action="{{ route('brochure.download') }}" method="post" enctype="multipart/form-data"
                            class="d-flex flex-wrap justify-content-between" novalidate>
                            @csrf
                            <input type="hidden" name="product_name" id="brochure_product_name" value="{{ $product->product_title ?? '' }}">
                            <input type="hidden" name="brochure" id="brochure_file_path" value="{{ $product->brochure ?? '' }}">
                            <div class="formGroup col--6">
                                <input type="text" id="name_brochure" name="name" placeholder="Name" autocomplete="name"
                                    required aria-describedby="name_brochureError">
                                <span id="name_brochureError" class="error-message d-none">
                                    Please enter your name
                                </span>
                            </div>

                            <div class="formGroup col--6">
                                <input type="email" id="email_brochure" name="email" placeholder="Email"
                                    autocomplete="email" required aria-describedby="email_brochureError">
                                <span id="email_brochureError" class="error-message d-none">
                                    Please enter a valid email
                                </span>
                            </div>

                            <div class="formGroup col--6">
                                <input type="tel" id="phone_brochure" name="phone_number" class="phone_number"
                                    placeholder="Phone" autocomplete="tel" required aria-describedby="phone_brochureError" >
                       
                                <span id="phone_brochureError" class="error-message d-none">
                                    Please enter a valid phone number
                                </span>
                            </div>

                            <div class="formGroup col--6">
                                <input type="text" id="product_enquiry_readonly" name="product_name_display" value="{{ $product->product_title ?? '' }}" readonly>
                            </div>

                            <div class="formGroup col-12">
                                <textarea id="message_brochure" name="message" placeholder="Message" rows="6"></textarea>
                            </div>

                            <div class="d-flex buttonGroup p-0 w-100">
                                <button type="submit" class="btn theme-btn bgBlack round">
                                    Download Brochure
                                </button>
                                <button type="button" class="btn theme-btn bgWhite round boder" data-bs-dismiss="modal"
                                    aria-label="Close" id="downloadBrochureFormCancel">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#downloadBrochureFormValidation').on('submit', function(e) {
        e.preventDefault();
        
        let $form = $(this);
        let $btn = $form.find('button[type="submit"]');
        let originalText = $btn.text();
        
        $btn.text('Processing...').prop('disabled', true);
        
        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                if (response.success && response.file_url) {
                    // Trigger download
                    const link = document.createElement('a');
                    link.href = response.file_url;
                    link.setAttribute('download', '');
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    
                    // Redirect after short delay
                    setTimeout(function() {
                        window.location.href = "{{ route('thank-you') }}";
                    }, 1200);
                } else {
                    alert('Error: ' + (response.message || 'Could not process download.'));
                    $btn.text(originalText).prop('disabled', false);
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON ? xhr.responseJSON.errors : null;
                if (errors) {
                    let firstError = Object.values(errors)[0][0];
                    alert(firstError);
                } else {
                    alert('Something went wrong. Please try again.');
                }
                $btn.text(originalText).prop('disabled', false);
            }
        });
    });
});
</script>
@endpush
