<footer class="footer-cariox">
    <div class="footer-cariox-main">
        <div class="container-ctn">
            <div class="footer-cariox-grid">
                <div class="footer-cariox-about">
                    <picture>
                        <img src="{{ $siteSetting->logo ? asset('storage/' . $siteSetting->logo) : asset('assets/images/logo.png') }}" alt="{{ $siteSetting->company_name ?? 'Cariox' }}" width="180" height="70" class="img-fluid">
                    </picture>
                    <p>{!! $siteSetting->footer_logo_description !!}</p>
                </div>
                <div class="footer-cariox-links-wrapper d-flex flex-wrap">
                    <div class="footer-cariox-menu">
                        <span>Main Menu</span>
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ url('about') }}">About Us</a></li>
                            <li><a href="{{ url('products') }}">Products</a></li>
                            <li><a href="{{ url('services') }}">Services</a></li>
                            <li><a href="{{ url('blogs') }}">Blogs</a></li>
                            <li><a href="{{ url('contact') }}">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="footer-cariox-quicklinks">
                        <span>Categories</span>
                        <ul>
                            @foreach($globalCategories->take(8) as $cat)
                            <li><a href="{{ route('product-category', $cat->slug) }}">{{ $cat->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @foreach($globalContacts->take(3) as $contact)
                    <div class="footer-cariox-contact">
                        <span>{{ $contact->country }}</span>
                        <div class="contact-line">
                            <img src="{{ asset('assets/images/icons/ion_location-outline.png') }}" width="16" height="16" alt="">
                            <p>{!! $contact->address !!}</p>
                        </div>
                        @foreach($contact->phones->take(1) as $phone)
                        <div class="contact-line">
                            <img src="{{ asset('assets/images/icons/solar_phone-outline.png') }}" width="16" height="16" alt="">
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone->phone_number) }}">{{ $phone->phone_number }}</a>
                        </div>
                        @endforeach
                        @foreach($contact->emails->take(1) as $email)
                        <div class="contact-line">
                            <img src="{{ asset('assets/images/icons/iconoir_mail.png') }}" width="16" height="16" alt="">
                            <a href="mailto:{{ $email->email }}">{{ $email->email }}</a>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                    <div class="footer-cariox-social-newsletter w-100">
                        <ul class="footer-cariox-social" aria-label="Social media">
                            @if($siteSetting->facebook_link)<li><a href="{{ $siteSetting->facebook_link }}" aria-label="Facebook" target="_blank"><img src="{{ asset('assets/images/icons/fb.png') }}" alt="" width="20" height="20"></a></li>@endif
                            @if($siteSetting->twitter_link)<li><a href="{{ $siteSetting->twitter_link }}" aria-label="Twitter" target="_blank"><img src="{{ asset('assets/images/icons/twitter.png') }}" alt="" width="20" height="20"></a></li>@endif
                            @if($siteSetting->linkedin_link)<li><a href="{{ $siteSetting->linkedin_link }}" aria-label="LinkedIn" target="_blank"><img src="{{ asset('assets/images/icons/link.png') }}" alt="" width="20" height="20"></a></li>@endif
                            @if($siteSetting->instagram_link)<li><a href="{{ $siteSetting->instagram_link }}" aria-label="Instagram" target="_blank"><img src="{{ asset('assets/images/icons/instagram.png') }}" alt="" width="20" height="20"></a></li>@endif
                            @if($siteSetting->pinterest_link)<li><a href="{{ $siteSetting->pinterest_link }}" aria-label="Pinterest" target="_blank"><img src="{{ asset('assets/images/icons/pinterest.png') }}" alt="" width="20" height="20"></a></li>@endif
                            @if($siteSetting->youtube_link)<li><a href="{{ $siteSetting->youtube_link }}" aria-label="YouTube" target="_blank"><img src="{{ asset('assets/images/icons/yt.png') }}" alt="" width="20" height="20"></a></li>@endif
                        </ul>

                        <div class="footer-cariox-newsletter d-flex align-items-center">
                            <label for="footer-email" class="m-0">Newsletter</label>
                            <form action="{{ url('/newsletter/subscribe') }}" method="post" class="newsletter-form">
                                @csrf
                                <input type="email" id="footer-email" placeholder="Enter email address" name="email" required>
                                <button type="submit" aria-label="Subscribe">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="22" y1="2" x2="11" y2="13" />
                                        <polygon points="22 2 15 22 11 13 2 9 22 2" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-cariox-copyright">
        <div class="container-ctn">
            {!! $siteSetting->copyright !!}
            @php
                $hasTerms = !empty(trim(strip_tags($siteSetting->terms_conditions)));
                $hasPrivacy = !empty(trim(strip_tags($siteSetting->privacy_policy)));
            @endphp
            @if($hasTerms || $hasPrivacy)
            <ul class="footer-cariox-policy">
                @if($hasTerms)
                <li><a href="{{ url('terms-and-conditions') }}">Terms & Conditions</a></li>
                @endif
                @if($hasPrivacy)
                <li><a href="{{ url('privacy-policy') }}">Privacy & Policy</a></li>
                @endif
            </ul>
            @endif
        </div>
    </div>
</footer>

<!-- menu mobile -->
<div class="offcanvas offcanvas-end mobile_left_menu" tabindex="-1" id="burgerMenu" aria-labelledby="mobileOffcanvasLabel" aria-modal="true" role="dialog">
    <div class="offcanvas-header">
        <h2 class="visually-hidden" id="mobileOffcanvasLabel">Mobile Menu</h2>
        <a href="{{ url('/') }}" aria-label="Website Logo">
            <picture>
                <img src="{{ $siteSetting->logo ? asset('storage/' . $siteSetting->logo) : asset('assets/images/logo.png') }}" alt="{{ $siteSetting->company_name ?? 'Cariox' }}" width="180" height="70" loading="lazy" class="img-fluid h-auto" />
            </picture>
        </a>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 25 25" fill="none">
                <path d="M1.8125 22.3203L22.3203 1.8125M22.3203 22.3203L1.8125 1.8125" stroke="#000" stroke-width="3.625" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
    </div>

    <div class="offcanvas-body container-ctn">
        <nav aria-label="Mobile primary navigation">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('about') }}">About</a></li>
                <li class="has-submenu">
                    <div class="menu-item-flex">
                        <a href="{{ url('products') }}">Products</a>
                        <button class="sub-menu-toggle" aria-label="Toggle Sub Menu" type="button">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                    <ul class="mobile-sub-menu">
                        @foreach($globalCategories as $cat)
                        <li><a href="{{ route('product-category', $cat->slug) }}">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="{{ url('services') }}">Services</a></li>
                <li><a href="{{ url('contact') }}">Contact</a></li>
            </ul>
        </nav>
    </div>
</div>

<!-- FIXED BOTTOM MENU (MOBILE) -->
<div class="bottomFixedMenu bottomFixedMenu--brand d-lg-none">
    <ul>
        <li> <a href="https://wa.me/+{{ $whatsappNumber }}?text=Can%20I%20get%20more%20details%20about%20your%20service?" aria-label="Chat with us on WhatsApp" target="_blank" rel="noopener">
                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 256 256">
                    <g fill="#fff">
                        <g transform="scale(5.12,5.12)">
                            <path d="M25,2c-12.682,0 -23,10.318 -23,23c0,3.96 1.023,7.854 2.963,11.29l-2.926,10.44c-0.096,0.343 -0.003,0.711 0.245,0.966c0.191,0.197 0.451,0.304 0.718,0.304c0.08,0 0.161,-0.01 0.24,-0.029l10.896,-2.699c3.327,1.786 7.074,2.728 10.864,2.728c12.682,0 23,-10.318 23,-23c0,-12.682 -10.318,-23 -23,-23zM36.57,33.116c-0.492,1.362 -2.852,2.605 -3.986,2.772c-1.018,0.149 -2.306,0.213 -3.72,-0.231c-0.857,-0.27 -1.957,-0.628 -3.366,-1.229c-5.923,-2.526 -9.791,-8.415 -10.087,-8.804c-0.295,-0.389 -2.411,-3.161 -2.411,-6.03c0,-2.869 1.525,-4.28 2.067,-4.864c0.542,-0.584 1.181,-0.73 1.575,-0.73c0.394,0 0.787,0.005 1.132,0.021c0.363,0.018 0.85,-0.137 1.329,1.001c0.492,1.168 1.673,4.037 1.819,4.33c0.148,0.292 0.246,0.633 0.05,1.022c-0.196,0.389 -0.294,0.632 -0.59,0.973c-0.296,0.341 -0.62,0.76 -0.886,1.022c-0.296,0.291 -0.603,0.606 -0.259,1.19c0.344,0.584 1.529,2.493 3.285,4.039c2.255,1.986 4.158,2.602 4.748,2.894c0.59,0.292 0.935,0.243 1.279,-0.146c0.344,-0.39 1.476,-1.703 1.869,-2.286c0.393,-0.583 0.787,-0.487 1.329,-0.292c0.542,0.194 3.445,1.604 4.035,1.896c0.59,0.292 0.984,0.438 1.132,0.681c0.148,0.242 0.148,1.41 -0.344,2.771z"></path>
                        </g>
                    </g>
                </svg>
                <span>Whatsapp</span>
            </a></li>
        <li>
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSetting->official_phone ?? '97167494981') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="17px" height="17px" viewBox="0 0 512 512" fill="none">
                    <path d="M512 133.12C512 296.107 295.893 512 133.12 512C97.4934 512 64.2134 498.56 39.6801 474.027L18.3467 449.493C-6.39992 424.747 -6.39992 382.933 19.4134 357.12C20.0534 356.48 71.4667 317.013 71.4667 317.013C97.0668 292.693 137.387 292.693 162.773 317.013L193.92 341.973C262.187 312.96 310.613 264.32 341.76 193.707L317.013 162.56C292.48 137.173 292.48 96.6401 317.013 71.2534C317.013 71.2534 356.48 19.8401 357.12 19.2001C382.933 -6.61325 424.747 -6.61325 450.56 19.2001L472.96 38.6134C498.56 64.0001 512 97.2801 512 132.907V133.12Z" fill="white" />
                </svg>
                <span>Phone</span>
            </a>
        </li>
        <li>
            <button type="button" data-bs-toggle="modal" data-bs-target="#siteGeneralEnquiryForm">
                <svg xmlns="http://www.w3.org/2000/svg" width="17px" height="17px" viewBox="0 0 512 513" fill="none">
                    <path d="M277.333 0H106.667C47.8507 0 0 47.8507 0 106.667V380.885C0 397.803 9.28 413.291 24.192 421.291C30.976 424.939 38.4213 426.731 45.8453 426.731C54.72 426.731 63.5733 424.149 71.2533 419.051L155.797 362.667H277.333C336.149 362.667 384 314.816 384 256V106.667C384 47.8507 336.149 0 277.333 0ZM512 192V466.219C512 483.136 502.72 498.624 487.808 506.624C481.024 510.272 473.579 512.064 466.155 512.085C457.28 512.085 448.427 509.504 440.768 504.405L356.203 448H234.667C203.733 448 176.064 434.539 156.565 413.44L168.704 405.333H277.333C359.659 405.333 426.667 338.325 426.667 256V106.667C426.667 100.096 426.091 93.696 425.28 87.3387C474.581 96.7253 512 140.011 512 192Z" fill="white" />
                </svg>
                <span>Enquiry</span>
            </button>
        </li>
    </ul>
</div>

<!-- LEFT FIXED BOX (DESKTOP) -->
<div class="leftFixedBox">
    <div class="QuickSideRightBar QuickSideRightBarWhatsapp">
        <a href="https://wa.me/+{{ $whatsappNumber }}?text=Can%20I%20get%20more%20details%20about%20your%20service?" target="_blank" rel="noopener">
            <div class="iconBox">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 35 35" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M29.7568 5.08667C26.4814 1.80833 22.1268 0.00145833 17.4878 0C7.92846 0 0.148255 7.77875 0.14388 17.3425C0.142422 20.3992 0.941589 23.3829 2.45971 26.0137L-0.00195312 35L9.19138 32.5879C11.7245 33.9704 14.577 34.6981 17.4791 34.6996H17.4864C27.0443 34.6996 34.826 26.9194 34.8303 17.3556C34.8333 12.7225 33.0308 8.36354 29.7568 5.08667ZM17.4878 31.7698H17.482C14.8949 31.7698 12.3589 31.0742 10.1451 29.7602L9.61867 29.4481L4.16305 30.8788L5.61992 25.5587L5.27721 25.0133C3.83346 22.7179 3.07221 20.0652 3.07367 17.3425C3.07659 9.39458 9.5443 2.92833 17.4951 2.92833C21.3451 2.92833 24.9647 4.43042 27.686 7.15458C30.4072 9.88021 31.9049 13.5013 31.9035 17.3527C31.8991 25.3035 25.4328 31.7698 17.4878 31.7698ZM25.3949 20.9738C24.9618 20.7565 22.8312 19.7079 22.433 19.5635C22.0364 19.4192 21.7476 19.3463 21.4574 19.7794C21.1672 20.2125 20.3389 21.1896 20.0851 21.4798C19.8328 21.7685 19.5791 21.805 19.146 21.5877C18.7128 21.3704 17.3158 20.914 15.6605 19.4367C14.3728 18.2875 13.5022 16.8685 13.2499 16.434C12.9976 15.9994 13.2237 15.766 13.4395 15.5502C13.6349 15.3563 13.8726 15.0442 14.0899 14.7904C14.3087 14.5396 14.3801 14.3588 14.526 14.0685C14.6703 13.7798 14.5989 13.526 14.4895 13.3088C14.3801 13.0929 13.5139 10.0917C12.8022 9.24583 12.4449 9.36104 12.178 9.34792C11.9258 9.33479 11.637 9.33333 11.3468 9.33333C11.058 9.33333 10.5885 9.44125 10.1918 9.87583C9.79513 10.3104 8.67513 11.359 8.67513 13.491C8.67513 15.6246 10.2283 17.6852 10.4441 17.974C10.6599 18.2627 13.4993 22.6406 17.8466 24.5175C18.8805 24.9638 19.6885 25.2306 20.317 25.4304C21.3553 25.76 22.3003 25.7133 23.047 25.6025C23.8797 25.4785 25.6108 24.554 25.9724 23.5419C26.3341 22.5298 26.3341 21.6606 26.2247 21.4812C26.1168 21.299 25.828 21.191 25.3949 20.9738Z" fill="white"></path>
                </svg>
            </div>
        </a>
    </div>
    <div class="QuickSideRightBar QuickSideRightBarPhone">
        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSetting->official_phone ?? '97167494981') }}">
            <div class="iconBox">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512" fill="none">
                    <path d="M512 133.12C512 296.107 295.893 512 133.12 512C97.4934 512 64.2134 498.56 39.6801 474.027L18.3467 449.493C-6.39992 424.747 -6.39992 382.933 19.4134 357.12C20.0534 356.48 71.4667 317.013 71.4667 317.013C97.0668 292.693 137.387 292.693 162.773 317.013L193.92 341.973C262.187 312.96 310.613 264.32 341.76 193.707L317.013 162.56C292.48 137.173 292.48 96.6401 317.013 71.2534C317.013 71.2534 356.48 19.8401 357.12 19.2001C382.933 -6.61325 424.747 -6.61325 450.56 19.2001L472.96 38.6134C498.56 64.0001 512 97.2801 512 132.907V133.12Z" fill="white" />
                </svg>
            </div>
        </a>
    </div>
    <div class="QuickSideRightBar QuickSideRightBarEnquiry">
        <a data-bs-toggle="modal" data-bs-target="#siteGeneralEnquiryForm" role="button" aria-label="Open enquiry form">
            <div class="iconBox">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 512 513" fill="none">
                    <path
                        d="M277.333 0H106.667C47.8507 0 0 47.8507 0 106.667V380.885C0 397.803 9.28 413.291 24.192 421.291C30.976 424.939 38.4213 426.731 45.8453 426.731C54.72 426.731 63.5733 424.149 71.2533 419.051L155.797 362.667H277.333C336.149 362.667 384 314.816 384 256V106.667C384 47.8507 336.149 0 277.333 0ZM512 192V466.219C512 483.136 502.72 498.624 487.808 506.624C481.024 510.272 473.579 512.064 466.155 512.085C457.28 512.085 448.427 509.504 440.768 504.405L356.203 448H234.667C203.733 448 176.064 434.539 156.565 413.44L168.704 405.333H277.333C359.659 405.333 426.667 338.325 426.667 256V106.667C426.667 100.096 426.091 93.696 425.28 87.3387C474.581 96.7253 512 140.011 512 192Z"
                        fill="white"></path>
                </svg>
            </div>
        </a>
    </div>
</div>