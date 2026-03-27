@extends('website.layouts.app')

@section('content')
<?php
$page_title = 'Contact Us | Cariox';
$page_desc = 'Get in touch with Cariox Technologies for industrial coding, inspection, and packaging support across the UAE, Saudi Arabia, and Uganda.';

?>
    <div class="inner-vector">
        <picture><img src="{{ asset('assets/images/inner/inner-vector.png') }}" alt="About Us"></picture>
    </div>
<section class="inner-banner contact-banner">
    <div class="container-ctn w-100">
        <div class="content">
            <h1 class="title">Contact Us</h1>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M12 12.75H6M2.25 8.9925V10.875C2.25 13.35 2.25 14.5875 3.01875 15.3563C3.7875 16.125 5.025 16.125 7.5 16.125H10.5C12.975 16.125 14.2125 16.125 14.9813 15.3563C15.75 14.5875 15.75 13.35 15.75 10.875V8.9925C15.75 7.731 15.75 7.101 15.483 6.555C15.216 6.009 14.718 5.622 13.7235 4.848L12.2235 3.68175C10.6748 2.47725 9.9 1.875 9 1.875C8.1 1.875 7.32525 2.47725 5.7765 3.68175L4.2765 4.848C3.28125 5.622 2.784 6.009 2.517 6.555C2.25 7.101 2.25 7.731 2.25 8.9925Z" stroke="black" stroke-width="1.125" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Home
                </a>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.99999 1.5C4.85788 1.5 1.5 4.85784 1.5 8.99999C1.5 13.1421 4.85788 16.5 8.99999 16.5C13.1422 16.5 16.5 13.1421 16.5 8.99999C16.5 4.85784 13.1422 1.5 8.99999 1.5ZM8.99999 15C5.69161 15 3.00001 12.3084 3.00001 8.99999C3.00001 5.69158 5.69158 3.00001 8.99999 3.00001C12.3084 3.00001 15 5.69158 15 8.99999C15 12.3084 12.3084 15 8.99999 15ZM9.93915 6C9.93915 6.5438 9.54322 6.93751 9.00762 6.93751C8.45036 6.93751 8.06413 6.54376 8.06413 5.98959C8.06413 5.45698 8.4608 5.06252 9.00762 5.06252C9.54322 5.06252 9.93915 5.45698 9.93915 6ZM8.25165 8.25H9.75163V12.75H8.25165V8.25Z" fill="#F04149"/>
                    </svg>
                    Contact Us
                </span>
            </nav>
        </div>
    </div>
</section>

<section class="contact-page commonPadding-120">
    <div class="container-ctn">
        <h2 class="text-center">Contact Info</h2>
        <div class="contact-page__layout d-flex flex-wrap">
            <aside class="contact-page__form-panel">
                <div class="contact-page__form-card">
                    <h3>Get in Touch</h3>
                    @if(session('success'))
                        <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form id="contactPageForm" class="contact-page__form" action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="formGroup">
                            <input type="text" name="name" placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <div style="color:#ff4040; font-size:0.85rem; margin-top:6px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="formGroup">
                            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                            @error('email')
                                <div style="color:#ff4040; font-size:0.85rem; margin-top:6px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="formGroup">
                            <input type="tel" name="phone" placeholder="Phone" class="phone_number" value="{{ old('phone') }}">
                            @error('phone')
                                <div style="color:#ff4040; font-size:0.85rem; margin-top:6px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="formGroup">
                            <input type="text" name="company" placeholder="Company" value="{{ old('company') }}">
                            @error('company')
                                <div style="color:#ff4040; font-size:0.85rem; margin-top:6px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="formGroup">
                            <textarea name="message" rows="6" placeholder="Message">{{ old('message') }}</textarea>
                            @error('message')
                                <div style="color:#ff4040; font-size:0.85rem; margin-top:6px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="contact-page__form-actions">
                            <button type="submit" class="btn btn-gradient">Send Messages</button>
                        </div>
                    </form>
                </div>
            </aside>

            <article class="contact-page__info-panel">
                @foreach($contacts as $contact)
                <div class="contact-info-card">
                    <div class="contact-info-card__top">
                        <div class="contact-info-card__icon">
                            @if($contact->icon)
                            <img src="{{ asset('storage/' . $contact->icon) }}" alt="{{ $contact->icon_alt }}" width="40" height="40">
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"> <path d="M31.25 16.25C31.25 13.2663 30.0647 10.4048 27.955 8.29505C25.8452 6.18526 22.9837 5 20 5C17.0163 5 14.1548 6.18526 12.045 8.29505C9.93526 10.4048 8.75 13.2663 8.75 16.25C8.75 20.865 12.4425 26.88 20 34.085C27.5575 26.88 31.25 20.865 31.25 16.25ZM20 37.5C10.8325 29.1675 6.25 22.0825 6.25 16.25C6.25 12.6033 7.69866 9.10591 10.2773 6.52728C12.8559 3.94866 16.3533 2.5 20 2.5C23.6467 2.5 27.1441 3.94866 29.7227 6.52728C32.3013 9.10591 33.75 12.6033 33.75 16.25C33.75 22.0825 29.1675 29.1675 20 37.5Z" fill="black"/> <path d="M20 20C20.9946 20 21.9484 19.6049 22.6517 18.9017C23.3549 18.1984 23.75 17.2446 23.75 16.25C23.75 15.2554 23.3549 14.3016 22.6517 13.5983C21.9484 12.8951 20.9946 12.5 20 12.5C19.0054 12.5 18.0516 12.8951 17.3483 13.5983C16.6451 14.3016 16.25 15.2554 16.25 16.25C16.25 17.2446 16.6451 18.1984 17.3483 18.9017C18.0516 19.6049 19.0054 20 20 20ZM20 22.5C18.3424 22.5 16.7527 21.8415 15.5806 20.6694C14.4085 19.4973 13.75 17.9076 13.75 16.25C13.75 14.5924 14.4085 13.0027 15.5806 11.8306C16.7527 10.6585 18.3424 10 20 10C21.6576 10 23.2473 10.6585 24.4194 11.8306C25.5915 13.0027 26.25 14.5924 26.25 16.25C26.25 17.9076 25.5915 19.4973 24.4194 20.6694C23.2473 21.8415 21.6576 22.5 20 22.5Z" fill="black"/> </svg>
                            @endif
                        </div>
                        {!! $contact->address !!}
                    </div>
                    <div class="contact-info-card__grid">
                        @foreach($contact->phones as $phone)
                        <div class="contact-info-card__action">
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone->phone_number) }}" class="contact-info-card__value">{{ $phone->phone_number }}</a>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone->phone_number) }}" class="contact-info-card__button">Call Us Now</a>
                        </div>
                        @endforeach
                        @foreach($contact->emails as $email)
                        <div class="contact-info-card__action">
                            <a href="mailto:{{ $email->email }}" class="contact-info-card__value">{{ $email->email }}</a>
                            <a href="mailto:{{ $email->email }}" class="contact-info-card__button">Email Us</a>
                        </div>
                        @endforeach
                    </div>
                    <div class="contact-info-card__footer">
                        <div class="contact-info-card__country">
                            @if($contact->country_logo)
                            <img src="{{ asset('storage/' . $contact->country_logo) }}" width="50" height="50" alt="{{ $contact->logo_alt ?? $contact->country }}" class="contact-info-card__flag">
                            @endif
                            <span>{{ $contact->country }}</span>
                        </div>
                        <div class="contact-info-card__links">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSetting->official_whatsapp ?? '971545864310') }}?text=Can%20I%20get%20more%20details%20about%20your%20service?" target="_blank" rel="noopener" class="contact-info-card__whatsapp">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 35 35" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M29.7568 5.08667C26.4814 1.80833 22.1268 0.00145833 17.4878 0C7.92846 0 0.148255 7.77875 0.14388 17.3425C0.142422 20.3992 0.941589 23.3829 2.45971 26.0137L-0.00195312 35L9.19138 32.5879C11.7245 33.9704 14.577 34.6981 17.4791 34.6996H17.4864C27.0443 34.6996 34.826 26.9194 34.8303 17.3556C34.8333 12.7225 33.0308 8.36354 29.7568 5.08667ZM17.4878 31.7698H17.482C14.8949 31.7698 12.3589 31.0742 10.1451 29.7602L9.61867 29.4481L4.16305 30.8788L5.61992 25.5587L5.27721 25.0133C3.83346 22.7179 3.07221 20.0652 3.07367 17.3425C3.07659 9.39458 9.5443 2.92833 17.4951 2.92833C21.3451 2.92833 24.9647 4.43042 27.686 7.15458C30.4072 9.88021 31.9049 13.5013 31.9035 17.3527C31.8991 25.3035 25.4328 31.7698 17.4878 31.7698ZM25.3949 20.9738C24.9618 20.7565 22.8312 19.7079 22.433 19.5635C22.0364 19.4192 21.7476 19.3463 21.4574 19.7794C21.1672 20.2125 20.3389 21.1896 20.0851 21.4798C19.8328 21.7685 19.5791 21.805 19.146 21.5877C18.7128 21.3704 17.3158 20.914 15.6605 19.4367C14.3728 18.2875 13.5022 16.8685 13.2499 16.434C12.9976 15.9994 13.2237 15.766 13.4395 15.5502C13.6349 15.3563 13.8726 15.0442 14.0899 14.7904C14.3087 14.5396 14.3801 14.3588 14.526 14.0685C14.6703 13.7798 14.5989 13.526 14.4895 13.3088C14.3801 13.0929 13.5139 10.9594 13.1537 10.0917C12.8022 9.24583 12.4449 9.36104 12.178 9.34792C11.9258 9.33479 11.637 9.33333 11.3468 9.33333C11.058 9.33333 10.5885 9.44125 10.1918 9.87583C9.79513 10.3104 8.67513 11.359 8.67513 13.491C8.67513 15.6246 10.2283 17.6852 10.4441 17.974C10.6599 18.2627 13.4993 22.6406 17.8466 24.5175C18.8805 24.9638 19.6885 25.2306 20.317 25.4304C21.3553 25.76 22.3003 25.7133 23.047 25.6025C23.8797 25.4785 25.6108 24.554 25.9724 23.5419C26.3341 22.5298 26.3341 21.6606 26.2247 21.4812C26.1168 21.299 25.828 21.191 25.3949 20.9738Z" fill="#111827"/>
                                </svg>
                                <span>WhatsApp Now</span>
                            </a>
                            @if($contact->map_link)
                            <a href="{{ $contact->map_link }}" target="_blank" class="contact-info-card__map">View Map</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </article>
        </div>
    </div>
</section>
@endsection