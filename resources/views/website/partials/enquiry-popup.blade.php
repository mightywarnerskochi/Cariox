<div class="modal fade siteEnquiryForm" id="siteEnquiryForm" aria-hidden="true" aria-labelledby="siteEnquiryFormLabel"
    tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                id="siteEnquiryFormClose">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                    <path d="M1.25 15.3933L15.3933 1.25M15.3933 15.3933L1.25 1.25" stroke="black" stroke-width="2.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <div class="modal-body p-0">
                <div class="modal-body-content">
                    <div class="modal-form">
                        <div class="modal-form__bg modal-form__bg--top"></div>
                        <div class="modal-form__bg modal-form__bg--bottom"></div>

                        <p class="title" id="siteEnquiryFormLabel">Quick Contact</p>

                        <form id="siteEnquiryFormValidation" action="{{ route('enquiry-submit') }}" method="post" enctype="multipart/form-data"
                            class="d-flex flex-wrap justify-content-between" novalidate>
                            @csrf
                            <input type="hidden" name="form_type" value="product">
                            <input type="hidden" name="product_id" id="product_id_enquiry" value="{{ $product->id ?? '' }}">
                            
                            <div class="formGroup col--6">
                                <input type="text" id="name_enquiry" name="name" placeholder="Name" autocomplete="name"
                                    required aria-describedby="name_enquiryError">
                                <span id="name_enquiryError" class="error-message d-none">
                                    Please enter your name
                                </span>
                            </div>

                            <div class="formGroup col--6">
                                <input type="email" id="email_enquiry" name="email" placeholder="Email"
                                    autocomplete="email" required aria-describedby="email_enquiryError">
                                <span id="email_enquiryError" class="error-message d-none">
                                    Please enter a valid email
                                </span>
                            </div>

                            <div class="formGroup col--6">
                                <input type="tel" id="phone_enquiry" name="phone_number" class="phone_number"
                                    placeholder="Phone" autocomplete="tel" required aria-describedby="phone_enquiryError" >
                       
                                <span id="phone_enquiryError" class="error-message d-none">
                                    Please enter a valid phone number
                                </span>
                            </div>

                            <div class="formGroup col--6">
                                <input type="text" id="product_enquiry" name="product_name" value="{{ $product->product_title ?? '' }}" readonly>
                            </div>

                            <div class="formGroup col-12">
                                <textarea id="message_enquiry" name="message" placeholder="Message" rows="6"></textarea>
                            </div>

                            <div class="d-flex buttonGroup p-0 w-100">
                                <button type="submit" class="btn theme-btn bgBlack round">
                                    Send Message
                                </button>
                                <button type="button" class="btn theme-btn bgWhite round boder" data-bs-dismiss="modal"
                                    aria-label="Close" id="siteEnquiryFormCancel">
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
