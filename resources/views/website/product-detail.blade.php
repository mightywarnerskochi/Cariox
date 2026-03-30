@extends('website.layouts.app')

@section('content')
<div class="inner-vector">
    <picture><img src="{{ asset('assets/images/inner/inner-vector.png') }}" alt="Cariox"></picture>
</div>
<section class="inner-banner product-detail-banner">
    <div class="container-ctn w-100">
        <div class="content">
            <h1 class="title">{{ $product->product_title }}</h1>
            <nav class="breadcrumb-new" aria-label="Breadcrumb">
                <div class="breadcrumb-pill">
                    <a href="{{ url('/') }}">Home</a>
                    <span class="dot">●</span>
                    <a href="{{ url('products') }}">Products</a>
                    <span class="dot">●</span>
                    <span class="current">{{ $product->product_title }}</span>
                </div>
            </nav>
        </div>
    </div>
</section>

<section class="product-detail">
    <div class="container-ctn">
        <div class="product-detail__top">
            <div class="product-gallery">
                <div class="product-main-slider">
                    @forelse($product->images as $image)
                    <div class="slide"><img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->product_title }}"></div>
                    @empty
                    <div class="slide"><img src="{{ asset('assets/images/products/1.png') }}" alt="{{ $product->product_title }}"></div>
                    @endforelse
                </div>
                <div class="product-gallery__nav-wrapper">
                    <div class="product-thumb-slider">
                        @foreach($product->images as $image)
                        <div class="thumb"><img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->product_title }} Thumb"></div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="product-info">
                <h2 class="product-info__title">{{ $product->product_title }}</h2>
                
                <div class="product-info__actions">
                    <div class="product-info__brand">
                            @if($product->brand && $product->brand->image)
                            <img src="{{ asset('storage/' . $product->brand->image) }}" alt="{{ $product->brand->name }}">
                            @else
                            <span>{{ $product->brand ? $product->brand->name : '' }}</span>
                            @endif
                    </div>
                    <button class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" data-product-name="{{ $product->product_title }}" data-product-id="{{ $product->id }}">Enquire Now</button>
                    @if($product->brochure)
                    <button class="btn-brochure" data-bs-toggle="modal" data-bs-target="#downloadBrochureForm" data-product-name="{{ $product->product_title }}" data-product-brochure="{{ $product->brochure }}">Download Brochure</button>
                    @endif
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSetting->official_whatsapp ?? '971545864310') }}?text=I am interested in {{ $product->product_title }}."
                        class="btn-whatsapp" target="_blank">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.94 3.659 1.437 5.63 1.438h.004c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" /></svg>
                        WhatsApp Us
                    </a>
                </div>

                <div class="product-info__description">
                    {!! $product->description ?? ' <p>description</p>'!!}
                </div>
            </div>
        </div>

        @php
            $hasFeatures = !empty($product->key_features);
            $hasVideos = ($product->videos && $product->videos->isNotEmpty());
            $hasOtherVideos = ($product->otherVideos && $product->otherVideos->isNotEmpty());
        @endphp

        @if($hasFeatures || $hasVideos)
        <div class="product-tabs">
            <ul class="product-tabs__nav">
                @if($hasFeatures)
                <li class="tab-item active" onclick="switchTab('features', this)">Key Features</li>
                @endif
                @if($hasVideos)
                <li class="tab-item {{ !$hasFeatures ? 'active' : '' }}" onclick="switchTab('videos', this)">Product Videos</li>
                @endif
            </ul>
            <div class="product-tabs__content">
                @if($hasFeatures)
                <div class="tab-pane active" id="features">
                    <div class="features-content">
                        {!! $product->key_features !!}
                    </div>
                </div>
                @endif
                @if($hasVideos)
                <div class="tab-pane {{ !$hasFeatures ? 'active' : '' }}" id="videos">
                    <div class="video-grid">
                        @foreach($product->videos as $video)
                        <div class="video-card">
                            <div class="video-poster">
                                <img src="{{ $video->poster ? asset('storage/' . $video->poster) : asset('assets/images/products/video-poster.jpg') }}" alt="{{ $product->product_title }}">
                                <button class="play-btn" type="button" aria-label="Play video">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                        <path d="M11.51 7.5617C11.3582 7.47168 11.1852 7.42345 11.0087 7.42191C10.8322 7.42037 10.6585 7.46557 10.5051 7.55292C10.3517 7.64028 10.2242 7.76667 10.1355 7.91926C10.0468 8.07185 10 8.2452 10 8.4217V31.5784C10 31.7549 10.0468 31.9282 10.1355 32.0808C10.2242 32.2334 10.3517 32.3598 10.5051 32.4471C10.6585 32.5345 10.8322 32.5797 11.0087 32.5782C11.1852 32.5766 11.3582 32.5284 11.51 32.4384L31.0483 20.86C31.1976 20.7715 31.3212 20.6456 31.407 20.4949C31.4929 20.3441 31.538 20.1735 31.538 20C31.538 19.8265 31.4929 19.656 31.407 19.5052C31.3212 19.3544 31.1976 19.2286 31.0483 19.14L11.51 7.5617Z" fill="white" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                            <video class="product-video" style="display: none;" controls>
                                <source src="{{ asset('storage/' . $video->video) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</section>  

<section class="product-videos">
   @if($hasOtherVideos)
    <div class="container-ctn">
        <div class="head mx-auto">
            <h2>Other Product Videos</h2>

        </div>
        <div class="video-grid">
             @foreach($product->otherVideos as $other)
            <div class="video-card other-video">
                @if($other->video_file)
                    <video class="product-video" controls width="100%">
                        <source src="{{ asset('storage/' . $other->video_file) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @elseif($other->video_url)
                    @php
                        $embedUrl = $other->video_url;
                        if (strpos($embedUrl, 'watch?v=') !== false) {
                            $embedUrl = str_replace('watch?v=', 'embed/', $embedUrl);
                        }
                    @endphp
                    <iframe width="100%" height="315" src="{{ $embedUrl }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                @endif
            </div>
             @endforeach
        </div>
    </div>
    @endif
</section>

<section class="major-products commonPadding-120 pt-0">
    <div class="container-ctn">
        <div class="head  mx-auto">
            <h2 class="title">Major Products</h2>
        </div>
        <div class="major-products-slider">
            @foreach($majorProducts as $p)
            <article class="product-catalog-card">
                <div class="product-catalog-card__image">
                    <img src="{{ $p->images->first() ? asset('storage/' . $p->images->first()->image) : asset('assets/images/shop/1.png') }}" alt="{{ $p->product_title }}">
                    <a href="{{ route('product-detail', $p->slug) }}" class="card-arrow-link">
                         <svg width="14" height="14" viewBox="0 0 12 12" fill="none"><path d="M1 11L11 1M11 1H4M11 1V8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
                <div class="product-catalog-card__content">
                    <h3>{{ $p->product_title }}</h3>
                    <p class="sub-title">{{ Str::limit($p->sub_title, 45) }}</p>
                    <div class="product-catalog-card__actions">
                        <a data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" role="button" data-product-name="{{ $p->product_title }}" data-product-id="{{ $p->id }}" class="btn-card-action btn-card-gradient">Enquire Now</a>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSetting->official_whatsapp ?? '971545864310') }}" class="btn-card-action btn-card-whatsapp" target="_blank">WhatsApp</a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

<style>
/* Global Detail Styles */
.breadcrumb-new { margin-top: 15px; }
.breadcrumb-pill { background: #f8f9fa; display: inline-flex; align-items: center; padding: 8px 24px; border-radius: 50px; gap: 10px; font-size: 14px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
.breadcrumb-pill a { color: #666; text-decoration: none; }
.breadcrumb-pill .dot { color: #F04149; }
.breadcrumb-pill .current { color: #F04149; font-weight: 500; }

/* Tabs & Features */
.product-tabs__nav { border-bottom: 2px solid #eee; margin-bottom: 30px; list-style: none; padding: 0; display: flex; gap: 30px; }
.tab-item { font-size: 18px; font-weight: 600; color: #999; cursor: pointer; padding-bottom: 15px; position: relative; }
.tab-item.active { color: #333; }
.tab-item.active::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 100%; height: 4px; background: linear-gradient(90deg, #FEB109, #F14448); border-radius: 2px; }

.features-list { list-style: none; padding: 0; display: flex; flex-direction: column; gap: 30px; }
.features-list li { display: flex; gap: 20px; align-items: flex-start; }
.features-list li::before {
    content: ''; width: 40px; height: 40px; flex-shrink: 0;
    background: linear-gradient(90deg, #FEB109 0%, #F14448 52.4%, #5B47C9 100%);
    border-radius: 50%;
    background-image: url('data:image/svg+xml,<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12H19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 5L19 12L12 19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>');
    background-size: 60%; background-repeat: no-repeat; background-position: center;
}

/* Major Products */
.major-products .section-head .title { font-size: 32px; font-weight: 700; margin-bottom: 20px; }

.product-catalog-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
.product-catalog-card__image { 
    height: 220px; position: relative; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; 
}
.product-catalog-card__image img { max-height: 100%; width: auto; object-fit: contain; }

.card-arrow-link { 
    position: absolute; top: 0; right: 0; width: 32px; height: 32px; 
    background: #F8F9FA; border-radius: 50%; display: flex; align-items: center; 
    justify-content: center; color: #333; transition: 0.3s;
}
.card-arrow-link:hover { background: #F04149; color: #fff; }

.product-catalog-card__content { text-align: left; }
.product-catalog-card__content h3 { font-size: 18px; font-weight: 600; margin-bottom: 8px; color: #1a1a1a; }
.product-catalog-card__content .sub-title { font-size: 14px; color: #646E82; margin-bottom: 20px; line-height: 1.4; }

.product-catalog-card__actions { display: flex; gap: 10px; }
.btn-card-action { 
    flex: 1; text-align: center; padding: 10px 5px; border-radius: 50px; 
    font-size: 12px; font-weight: 600; text-decoration: none; transition: 0.3s; 
}
.btn-card-gradient { background: linear-gradient(90deg, #F04149 0%, #FF9700 100%); color: #fff; }
.btn-card-whatsapp { border: 1px solid #25D366; color: #25D366; }

/* Slick Dots Styling */
.major-products-slider .slick-dots li { margin: 0; width: 20px; height: 8px; }
.major-products-slider .slick-dots li button { width: 100%; height: 100%; padding: 0; border-radius: 10px; background: #E4E8ED; border: none; text-indent: -9999px; }
.major-products-slider .slick-dots li.slick-active { width: 40px; }
.major-products-slider .slick-dots li.slick-active button { background: #5E47C6; }

@media (max-width: 768px) {
    .product-catalog-card__actions { display: none; }
    .card-arrow-link { width: 28px; height: 28px; }
}
</style>

@push('scripts')
<script>
$(document).ready(function(){
    $('.major-products-slider').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        dots: true,
        arrows: false,
        responsive: [
            { breakpoint: 1200, settings: { slidesToShow: 3 } },
            { breakpoint: 768, settings: { slidesToShow: 2, dots: true } },
            { breakpoint: 576, settings: { slidesToShow: 1 } }
        ]
    });
});

function switchTab(tabId, btn) {
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-item').forEach(b => b.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
    btn.classList.add('active');
}
</script>
@endpush
@endsection