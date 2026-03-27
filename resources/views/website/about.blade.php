@extends('website.layouts.app')

@section('content')
<?php
$page_title = 'About Us | Cariox';
$page_desc = '';

?>
    <div class="inner-vector">
        <picture><img src="{{ asset('assets/images/inner/inner-vector.png') }}" alt="About Us"></picture>
    </div>
    <section class="inner-banner about-banner">
        <div class="container-ctn w-100">
            <div class="content ">
                <h1 class="title">About Us</h1>
                <nav class="breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ url('/') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M12 12.75H6M2.25 8.9925V10.875C2.25 13.35 2.25 14.5875 3.01875 15.3563C3.7875 16.125 5.025 16.125 7.5 16.125H10.5C12.975 16.125 14.2125 16.125 14.9813 15.3563C15.75 14.5875 15.75 13.35 15.75 10.875V8.9925C15.75 7.731 15.75 7.101 15.483 6.555C15.216 6.009 14.718 5.622 13.7235 4.848L12.2235 3.68175C10.6748 2.47725 9.9 1.875 9 1.875C8.1 1.875 7.32525 2.47725 5.7765 3.68175L4.2765 4.848C3.28125 5.622 2.784 6.009 2.517 6.555C2.25 7.101 2.25 7.731 2.25 8.9925Z" stroke="black" stroke-width="1.125" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Home</a>
                  </span>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.99999 1.5C4.85788 1.5 1.5 4.85784 1.5 8.99999C1.5 13.1421 4.85788 16.5 8.99999 16.5C13.1422 16.5 16.5 13.1421 16.5 8.99999C16.5 4.85784 13.1422 1.5 8.99999 1.5ZM8.99999 15C5.69161 15 3.00001 12.3084 3.00001 8.99999C3.00001 5.69158 5.69158 3.00001 8.99999 3.00001C12.3084 3.00001 15 5.69158 15 8.99999C15 12.3084 12.3084 15 8.99999 15ZM9.93915 6C9.93915 6.5438 9.54322 6.93751 9.00762 6.93751C8.45036 6.93751 8.06413 6.54376 8.06413 5.98959C8.06413 5.45698 8.4608 5.06252 9.00762 5.06252C9.54322 5.06252 9.93915 5.45698 9.93915 6ZM8.25165 8.25H9.75163V12.75H8.25165V8.25Z" fill="#F04149"/>
                        </svg>
                        About Us
                    </span>
                </nav>
            </div>
        </div>
    </section>



    <section class="clients-and-who-we-are pt-0">

        <div class="who-we-are commonPadding-120">
            <div class="container-ctn">
                <div class="d-flex flex-wrap who-we-are-wrapper align-items-center">
                    <div class="who-we-are-left">
                        <div class="image-montage">
                            <div class="dots-bg">
                                <img src="{{ asset('assets/images/home/who-we-are/doted.png') }}" alt="">
                            </div>
                            <div class="dots-bg-bottom">
                                <img src="{{ asset('assets/images/home/who-we-are/doted.png') }}" alt="">
                            </div>
                            <div class="main-img">
                                @php $mainAboutImage = $about->images->where('status', 1)->sortBy('order')->first(); @endphp
                                <img
                                    src="{{ $mainAboutImage && $mainAboutImage->image ? asset('storage/' . $mainAboutImage->image) : asset('assets/images/home/who-we-are/who-we-are.jpg') }}"
                                    alt="{{ $mainAboutImage->alt_text ?? 'Who We Are' }}"
                                >
                            </div>
                            <div class="exp-badge">
                                <span class="num" data-counter-target="{{ $about->years_of_experience ?? 15 }}">{{ $about->years_of_experience ?? 15 }}</span>
                                <span class="txt">{{ $about->experience_caption ?? "Years of experience" }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="who-we-are-right">
                        <div class="content-area">
                            <div class="head">
                                <h2>{{ $aboutSection->main_title ?? 'Who we are' }}</h2>
                            </div>
                            {!! $about->detailed_description ?? $aboutSection->description ?? '<p>About Us description goes here</p>' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
                    

        <div class="vision-mission ">
            <div class="container-ctn">
                <div class="d-flex flex-wrap justify-content-between vision-mission-wrapper">
                    <div class="vision">
                        <div class="head">
                            <h3>Our Vision</h3>
                        </div>
                        {!! $about->vision ?? '<p>Our vision description</p>' !!}
                    </div>
                    <div class="mission ">
                        <div class="head">
                            <h3>Our Mission</h3>
                        </div>
                        {!! $about->mission ?? '<p>Our mission description</p>' !!}
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="reason-for-choosing commonPadding-120">
        <div class="container-ctn">
            <div class="content">
                <h2>{{ $chooseUs->title ?? 'Reason for choosing us' }}</h2>
                <p>
                    {!! $chooseUs->description ?? '<p>Description goes here</p>' !!}
                </p>
                <div class="reason-for-choosing__frame">
                    <picture class="reason-for-choosing__side-art reason-for-choosing__side-art--left">
                        <img src="{{ asset('assets/images/left.png') }}" alt="" aria-hidden="true">
                    </picture>
                    <picture class="reason-for-choosing__side-art reason-for-choosing__side-art--right">
                        <img src="{{ asset('assets/images/right.png') }}" alt="" aria-hidden="true">
                    </picture>

                    <div class="reason-for-choosing__badges">
                        @if(isset($chooseUsItems) && $chooseUsItems->count() > 0)
                            @php $colors = ['color-blue', 'color-violet', 'color-orange', 'color-gold', 'color-rose', 'color-sky']; @endphp
                            @foreach($chooseUsItems as $index => $item)
                            <div class="reason-for-choosing__badge {{ $colors[$index % count($colors)] }}">
                                <span class="icon">
                                    @if(!empty($item->image))
                                        <img src="{{ asset('storage/' . $item->image) }}" width="24" height="24" alt="{{ $item->text }}">
                                    @else
                                        <i class="{{ $item->icon ?: 'fas fa-info-circle' }}"></i>
                                    @endif
                                </span>
                                <span>{{ $item->text }}</span>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="reason-for-choosing__image">
                        <picture>
                            <img src="{{ isset($chooseUs->image) ? asset('storage/' . $chooseUs->image) : asset('assets/images/about/reason.jpg') }}" width="614" height="274" alt="{{ $chooseUs->alt_text ?? 'Reason' }}">
                        </picture>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="timeline commonPadding-120 pt-0">
        <div class="container-ctn">
            <div class="timeline__content">
                <h2>Meet with our company journey</h2>
                <div class="timeline-slider">
                    @if(isset($journeys) && $journeys->count() > 0)
                        @foreach($journeys as $index => $journey)
                        <article class="timeline__slide">
                            <div class="timeline__feature-frame">
                                <picture>
                                    <img src="{{ asset('storage/' . $journey->image) }}" width="270" height="423" alt="{{ $journey->image_alt_text ?? $journey->caption ?? $journey->year }}">
                                </picture>
                                <div class="timeline__feature-copy">
                               <div>
                                     <div class="timeline__year">{{ $journey->year }}</div>
                                    <h3>{{ $journey->caption ?? $journey->year }}</h3>
                                    <span class="timeline__count">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    {!! $journey->description !!}
                               </div>
                                </div>
                            </div>
                            <div class="timeline__milestone">
                                <div class="timeline__year">{{ $journey->year }}</div>
                                <p>{{ $journey->caption ?? $journey->year }}</p>
                                <span class="timeline__count">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </article>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="brands commonPadding-120">
        <div class="container-ctn">
            <div class="head text-center">
                <span class="label-pill">{{ $brandSection->small_title ?? 'Our Brands' }}</span>
                <h2>{{ $brandSection->main_title ?? 'Brand we serve' }}</h2>
                {!! $brandSection->description ?? '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>' !!}
                <div class="brand-slider">
                    @if(isset($brands) && $brands->count() > 0)
                        @foreach($brands as $brand)
                            <picture><img src="{{ asset('storage/' . $brand->image) }}" width="175" height="120" alt="{{ $brand->alt_text ?? $brand->name }}"></picture>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>


    
    <footer class="footer-cariox">
@endsection