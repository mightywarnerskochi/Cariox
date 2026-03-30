@extends('website.layouts.app')

@section('content')
<?php
$page_title = 'Installation | Cariox';
$page_desc = '';

?>
<div class="inner-vector">
    <picture><img src="{{ asset('assets/images/inner/inner-vector.png') }}" alt="Services"></picture>
</div>
<section class="inner-banner services-banner">
    <div class="container-ctn w-100">
        <div class="content ">
            <h1 class="title">{{ $service->name }}</h1>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path
                            d="M12 12.75H6M2.25 8.9925V10.875C2.25 13.35 2.25 14.5875 3.01875 15.3563C3.7875 16.125 5.025 16.125 7.5 16.125H10.5C12.975 16.125 14.2125 16.125 14.9813 15.3563C15.75 14.5875 15.75 13.35 15.75 10.875V8.9925C15.75 7.731 15.75 7.101 15.483 6.555C15.216 6.009 14.718 5.622 13.7235 4.848L12.2235 3.68175C10.6748 2.47725 9.9 1.875 9 1.875C8.1 1.875 7.32525 2.47725 5.7765 3.68175L4.2765 4.848C3.28125 5.622 2.784 6.009 2.517 6.555C2.25 7.101 2.25 7.731 2.25 8.9925Z"
                            stroke="black" stroke-width="1.125" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Home</a>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path
                            d="M16.3125 14.0625H15.1875V12.9375H15.75V10.6875H13.5V11.25H12.375V10.125C12.375 9.97582 12.4343 9.83274 12.5398 9.72725C12.6452 9.62176 12.7883 9.5625 12.9375 9.5625H16.3125C16.4617 9.5625 16.6048 9.62176 16.7102 9.72725C16.8157 9.83274 16.875 9.97582 16.875 10.125V13.5C16.875 13.6492 16.8157 13.7923 16.7102 13.8977C16.6048 14.0032 16.4617 14.0625 16.3125 14.0625Z"
                            fill="#F04149" />
                        <path
                            d="M13.5 16.8745H10.125C9.97581 16.8745 9.83274 16.8153 9.72725 16.7098C9.62176 16.6043 9.5625 16.4612 9.5625 16.312V12.937C9.5625 12.7878 9.62176 12.6448 9.72725 12.5393C9.83274 12.4338 9.97581 12.3745 10.125 12.3745H13.5C13.6492 12.3745 13.7923 12.4338 13.8977 12.5393C14.0032 12.6448 14.0625 12.7878 14.0625 12.937V16.312C14.0625 16.4612 14.0032 16.6043 13.8977 16.7098C13.7923 16.8153 13.6492 16.8745 13.5 16.8745ZM10.6875 15.7495H12.9375V13.4995H10.6875V15.7495ZM8.4375 11.1696C8.03106 11.0637 7.66246 10.8459 7.37357 10.5411C7.08467 10.2362 6.88705 9.85641 6.80315 9.44486C6.71924 9.03331 6.75242 8.60648 6.8989 8.21284C7.04539 7.8192 7.29931 7.47451 7.63184 7.21793C7.96438 6.96135 8.36219 6.80315 8.78012 6.76129C9.19804 6.71944 9.61933 6.79561 9.99614 6.98115C10.373 7.16669 10.6902 7.45417 10.9118 7.81095C11.1335 8.16773 11.2506 8.5795 11.25 8.99952H12.375C12.3757 8.35591 12.1923 7.72553 11.8464 7.18271C11.5006 6.6399 11.0068 6.20728 10.4232 5.93587C9.83966 5.66445 9.19064 5.56557 8.5527 5.65087C7.91477 5.73617 7.31453 6.00209 6.82275 6.41729C6.33098 6.83249 5.96817 7.37965 5.77712 7.99425C5.58607 8.60885 5.57474 9.26526 5.74446 9.88609C5.91418 10.5069 6.25788 11.0663 6.73503 11.4982C7.21218 11.9301 7.80289 12.2166 8.4375 12.3239V11.1696Z"
                            fill="#F04149" />
                        <path
                            d="M16.2498 7.62188L14.9505 8.76375L14.1517 7.965L15.5073 6.7725L14.1798 4.4775L12.2448 5.13C11.7914 4.75299 11.278 4.4545 10.7261 4.24688L10.3267 2.25H7.67171L7.27234 4.24688C6.716 4.44883 6.19989 4.74783 5.74796 5.13L3.81859 4.4775L2.49109 6.7725L4.02109 8.11688C3.91708 8.69914 3.91708 9.29523 4.02109 9.8775L2.49109 11.2275L3.81859 13.5225L5.75359 12.87C6.20705 13.247 6.72038 13.5455 7.27234 13.7531L7.67171 15.75H8.43671V16.875H7.67171C7.41157 16.8748 7.15955 16.7844 6.95853 16.6193C6.75752 16.4542 6.61994 16.2245 6.56921 15.9694L6.28234 14.5519C6.02734 14.4283 5.78114 14.2873 5.54546 14.13L4.17859 14.5913C4.06244 14.6294 3.94085 14.6484 3.81859 14.6475C3.62096 14.649 3.42652 14.5977 3.25541 14.4988C3.08431 14.3999 2.94277 14.257 2.84546 14.085L1.51796 11.79C1.38667 11.5644 1.33788 11.3003 1.37995 11.0427C1.42203 10.7851 1.55234 10.5502 1.74859 10.3781L2.82859 9.43313C2.81734 9.28688 2.81171 9.14625 2.81171 9C2.81171 8.85375 2.82296 8.71312 2.83421 8.5725L1.74859 7.62188C1.55234 7.44982 1.42203 7.21489 1.37995 6.95732C1.33788 6.69974 1.38667 6.43556 1.51796 6.21L2.84546 3.915C2.94277 3.74298 3.08431 3.60012 3.25541 3.50121C3.42652 3.40231 3.62096 3.35096 3.81859 3.3525C3.94085 3.35156 4.06244 3.37056 4.17859 3.40875L5.53984 3.87C5.77818 3.71384 6.02618 3.57294 6.28234 3.44813L6.56921 2.03062C6.61994 1.77548 6.75752 1.5458 6.95853 1.38068C7.15955 1.21556 7.41157 1.12521 7.67171 1.125H10.3267C10.5868 1.12521 10.8389 1.21556 11.0399 1.38068C11.2409 1.5458 11.3785 1.77548 11.4292 2.03062L11.7161 3.44813C11.9711 3.57171 12.2173 3.71267 12.453 3.87L13.8198 3.40875C13.936 3.37056 14.0576 3.35156 14.1798 3.3525C14.3775 3.35096 14.5719 3.40231 14.743 3.50121C14.9141 3.60012 15.0557 3.74298 15.153 3.915L16.4805 6.21C16.6118 6.43556 16.6605 6.69974 16.6185 6.95732C16.5764 7.21489 16.4461 7.44982 16.2498 7.62188Z"
                            fill="#F04149" />
                    </svg>{{ $service->name }}
                </span>
            </nav>
        </div>
    </div>
</section>

<section class="service-detail-page commonPadding-120">
    <div class="container-ctn">
        <div class="service-detail-grid ">
            <aside class="service-sidebar">
                <div class="sidebar-box">
                    <h3 class="sidebar-title">Our Services</h3>
                    <ul class="sidebar-services-list">
                        @php $allServices = \App\Models\Service::where('status', 1)->orderBy('position')->get(); @endphp
                        @foreach($allServices as $s)
                        <li class="{{ $service->id == $s->id ? 'active' : '' }}"><a href="{{ route('service-detail', $s->slug) }}">{{ $s->name }}</a></li>
                        @endforeach
                    </ul>

                    <div class="contact-now-card sidebar-contact-card">
                        <h3 class="sidebar-title contact-title">Contact Now</h3>
                        @php
                            $callPhone = $siteSetting->official_phone ?? '+971 6 749 4981';
                            $whatsappSource = $siteSetting->official_whatsapp ?? $callPhone;
                            $whatsappDigits = preg_replace('/[^0-9]/', '', $whatsappSource);
                        @endphp
                        <div class="contact-methods">
                            <div class="method-item phone">
                                <span class="val">{{ $callPhone }}</span>
                                <a  href="tel:{{ preg_replace('/[^0-9+]/', '', $callPhone) }}" class="method-btn">Call Us Now</a>
                            </div>
                            <div class="method-item email">
                                <span class="val">{{ $siteSetting->official_email }}</span>
                                <a href="mailto:{{ $siteSetting->official_email }}" class="method-btn">Email Us</a>
                            </div>
                        </div>
                        <div class="whatsapp-wrapper">
                            <a href="https://wa.me/{{ $whatsappDigits }}?text=Can%20I%20get%20more%20details%20about%20your%20service?" target="_blank" class="btn btn-gradient">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M19.0508 4.91042C18.1338 3.98453 17.0418 3.25039 15.8383 2.75078C14.6348 2.25118 13.3439 1.9961 12.0408 2.00042C6.58078 2.00042 2.13078 6.45042 2.13078 11.9104C2.13078 13.6604 2.59078 15.3604 3.45078 16.8604L2.05078 22.0004L7.30078 20.6204C8.75078 21.4104 10.3808 21.8304 12.0408 21.8304C17.5008 21.8304 21.9508 17.3804 21.9508 11.9204C21.9508 9.27042 20.9208 6.78042 19.0508 4.91042ZM12.0408 20.1504C10.5608 20.1504 9.11078 19.7504 7.84078 19.0004L7.54078 18.8204L4.42078 19.6404L5.25078 16.6004L5.05078 16.2904C4.22833 14.9775 3.79171 13.4597 3.79078 11.9104C3.79078 7.37042 7.49078 3.67042 12.0308 3.67042C14.2308 3.67042 16.3008 4.53042 17.8508 6.09042C18.6184 6.85428 19.2267 7.76296 19.6404 8.76375C20.0541 9.76453 20.265 10.8375 20.2608 11.9204C20.2808 16.4604 16.5808 20.1504 12.0408 20.1504ZM16.5608 13.9904C16.3108 13.8704 15.0908 13.2704 14.8708 13.1804C14.6408 13.1004 14.4808 13.0604 14.3108 13.3004C14.1408 13.5504 13.6708 14.1104 13.5308 14.2704C13.3908 14.4404 13.2408 14.4604 12.9908 14.3304C12.7408 14.2104 11.9408 13.9404 11.0008 13.1004C10.2608 12.4404 9.77078 11.6304 9.62078 11.3804C9.48078 11.1304 9.60078 11.0004 9.73078 10.8704C9.84078 10.7604 9.98078 10.5804 10.1008 10.4404C10.2208 10.3004 10.2708 10.1904 10.3508 10.0304C10.4308 9.86042 10.3908 9.72042 10.3308 9.60042C10.2708 9.48042 9.77078 8.26042 9.57078 7.76042C9.37078 7.28042 9.16078 7.34042 9.01078 7.33042H8.53078C8.36078 7.33042 8.10078 7.39042 7.87078 7.64042C7.65078 7.89042 7.01078 8.49042 7.01078 9.71042C7.01078 10.9304 7.90078 12.1104 8.02078 12.2704C8.14078 12.4404 9.77078 14.9404 12.2508 16.0104C12.8408 16.2704 13.3008 16.4204 13.6608 16.5304C14.2508 16.7204 14.7908 16.6904 15.2208 16.6304C15.7008 16.5604 16.6908 16.0304 16.8908 15.4504C17.1008 14.8704 17.1008 14.3804 17.0308 14.2704C16.9608 14.1604 16.8108 14.1104 16.5608 13.9904Z"
                                        fill="white" />
                                </svg>
                                WhatsApp Now
                            </a>
                        </div>
                    </div>

                    <h3 class="sidebar-title enquire-title">Enquire Now</h3>
                    
                    @if(session('success'))
                        <div class="alert alert-success" style="padding: 10px; border-radius: 5px; background: #d1fae5; color: #065f46; margin-bottom: 15px; font-size: 0.875rem;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger" style="padding: 10px; border-radius: 5px; background: #fee2e2; color: #991b1b; margin-bottom: 15px; font-size: 0.875rem;">
                            <ul style="margin: 0; padding-left: 15px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('enquiry-submit') }}" method="POST" class="sidebar-enquire-form">
                        @csrf
                        <input type="hidden" name="form_type" value="Service Detail">
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        
                        <div class="formGroup">
                            <input type="text" name="name" placeholder="Name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="formGroup">
                            <input type="email" name="email" placeholder="Email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="formGroup">
                            <input type="tel" name="phone_number" placeholder="+971 Phone" class="form-control phone_number" value="{{ old('phone_number') }}" required>
                        </div>
                        <div class="formGroup">
                            <input type="text" name="company" placeholder="Company" class="form-control" value="{{ old('company') }}">
                        </div>
                        <div class="formGroup">
                            <textarea name="message" placeholder="Message" class="form-control" rows="4" required>{{ old('message') }}</textarea>
                        </div>
                        <div class="formGroup">
                            <button type="submit" class="btn btn-gradient ">Send Message</button>
                        </div>
                    </form>
                </div>
            </aside>

            <main class="service-main features-list">
                @if($service->background_image)
                <picture>
                    <img src="{{ asset('storage/' . $service->background_image) }}" alt="{{ $service->background_image_alt_text }}" width="1080" height="480"
                        class="img-fluid">
                </picture>
                @endif


                <div class="service-text-content ">
                    {!! $service->main_description ?? ' <p>description</p>'!!}
                </div>

                <div class="service-gallery ">
                    @if($service->base_image1)
                    <div class="gallery-item">
                        <img src="{{ asset('storage/' . $service->base_image1) }}" alt="{{ $service->name }}">
                    </div>
                    @endif
                    @if($service->base_image2)
                    <div class="gallery-item">
                        <img src="{{ asset('storage/' . $service->base_image2) }}" alt="{{ $service->name }}">
                    </div>
                    @endif
                </div>

            </main>
        </div>
    </div>
</section>
@endsection