<div class="modal fade siteEnquiryForm" id="siteGeneralEnquiryForm" aria-hidden="true" aria-labelledby="siteGeneralEnquiryFormLabel"
    tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                id="siteGeneralEnquiryFormClose">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                    <path d="M1.25 15.3933L15.3933 1.25M15.3933 15.3933L1.25 1.25" stroke="black" stroke-width="2.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <div class="modal-body p-0">
                <div class="modal-body-content">
                    <div class="modal-form">
                        <div class="modal-form__bg modal-form__bg--top"></div>
                        <div class="modal-form__bg modal-form__bg--bottom"></div>

                        <p class="title" id="siteGeneralEnquiryFormLabel">General Enquiry</p>

                        <form id="siteGeneralEnquiryFormValidation" action="" method="post" enctype="multipart/form-data"
                            class="d-flex flex-wrap justify-content-between" novalidate>
                            <div class="formGroup col--6">
                                <input type="text" id="name_general" name="name_general" placeholder="Name" autocomplete="name"
                                    required aria-describedby="name_generalError">
                                <span id="name_generalError" class="error-message d-none">
                                    Please enter your name
                                </span>
                            </div>

                            <div class="formGroup col--6">
                                <input type="email" id="email_general" name="email_general" placeholder="Email"
                                    autocomplete="email" required aria-describedby="email_generalError">
                                <span id="email_generalError" class="error-message d-none">
                                    Please enter a valid email
                                </span>
                            </div>

                            <div class="formGroup col--6">
                                <input type="tel" id="phone_general" name="phone_general" class="phone_number "
                                    placeholder="Phone" autocomplete="tel" required aria-describedby="phone_generalError" >
                       
                                <span id="phone_generalError" class="error-message d-none">
                                    Please enter a valid phone number
                                </span>
                            </div>

                            <div class="formGroup col--6">
                                <input type="text" id="company_general" name="company_general" placeholder="Company" 
                                    required aria-describedby="company_generalError">
                                <span id="company_generalError" class="error-message d-none">
                                    Please enter your company
                                </span>
                            </div>

                            <div class="formGroup col-12">
                                <textarea id="message_general" name="message_general" placeholder="Message" rows="6"></textarea>
                            </div>

                            <div class="d-flex buttonGroup p-0 w-100">
                                <button type="submit" class="btn theme-btn bgBlack round">
                                    Send Message
                                </button>
                                <button type="button" class="btn theme-btn bgWhite round boder" data-bs-dismiss="modal"
                                    aria-label="Close" id="siteGeneralEnquiryFormCancel">
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
