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
                <div class="modal-body-content d-flex flex-wrap">
                    <div class="modal-image ">
                         <img src="public/images/popup.jpg" alt="Enquiry" class="img-fluid  w-100 object-fit-cover">
                    </div>
                    <div class="modal-form ">
                        <svg class="modal-bg-svg" xmlns="http://www.w3.org/2000/svg" width="165" height="351" viewBox="0 0 165 351" fill="none"><path d="M164.633 349.76C111.563 349.76 64.2814 324.331 34.2625 284.962C13.0829 257.202 0.499914 222.514 0.499914 184.92V0.5H73.8313V184.937C73.8313 235.219 114.561 276.138 164.633 276.138" stroke="black" stroke-opacity="0.12" stroke-miterlimit="10"/></svg>
                        <!-- Label used by aria-labelledby -->
                        <p class="title " id="siteEnquiryFormLabel">
                            Book Now
                        </p>


                        <form id="siteEnquiryFormValidation" action="" method="post" enctype="multipart/form-data"
                            class="d-flex flex-wrap justify-content-between" novalidate>
                            <div class="formGroup col--6">
                                <input type="text" id="name_enquiry" name="name_enquiry" placeholder="Name" autocomplete="name"
                                    required aria-describedby="name_enquiryError">
                                <span id="name_enquiryError" class="error-message d-none">
                                    Please enter your name
                                </span>
                            </div>

                            <div class="formGroup col--6">
                                <input type="email" id="email_enquiry" name="email_enquiry" placeholder="Email"
                                    autocomplete="email" required aria-describedby="email_enquiryError">
                                <span id="email_enquiryError" class="error-message d-none">
                                    Please enter a valid email
                                </span>
                            </div>

                            <div class="formGroup col--6">
                                <input type="tel" id="phone_enquiry" name="phone_enquiry" class="phone_number"
                                    placeholder="Phone Number*" autocomplete="tel" required aria-describedby="phone_enquiryError">
                                <span id="phone_enquiryError" class="error-message d-none">
                                    Please enter a valid phone number
                                </span>
                            </div>
                            <div class="formGroup col--6">
                                <select class="select" id="services_enquiry" name="services_enquiry">
                                    <option value="">Select Services</option>
                                    <option>Mobile Podcast Production</option>
                                    <option>Cinematic Set Podcasts</option>
                                    <option>Studio Podcast</option>
                                    <option>Video Editing & Post-Production</option>
                                </select>
                                <span id="services_enquiryError" class="error-message d-none">
                                    Please select a service
                                </span>
                            </div>

                            <div class="formGroup col-12">
                                <textarea id="message_enquiry" name="message_enquiry" placeholder="Message" rows="4"></textarea>
                            </div>

                            <div class="d-flex justify-content-end buttonGroup p-0 w-100">
                                <button type="submit" class="btn theme-btn bgBlack round me-2">
                                    Book Now
                                </button>
                                <button type="button" class=" btn theme-btn bgWhite round boder" data-bs-dismiss="modal"
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