@extends('website.layouts.app')

@section('content')
<div class="inner-vector">
    <picture><img src="{{ asset('assets/images/inner/inner-vector.png') }}" alt="Cariox"></picture>
</div>
<section class="inner-banner product-detail-banner">
    <div class="container-ctn w-100">
        <div class="content">
            <h1 class="title">{{ $category->name }}</h1>
            <nav class="breadcrumb-new" aria-label="Breadcrumb">
                <div class="breadcrumb-pill">
                    <a href="{{ url('/') }}">Home</a>
                    <span class="dot">●</span>
                    <a href="{{ url('products') }}">Products</a>
                    <span class="dot">●</span>
                    <span class="current">{{ $category->name }}</span>
                </div>
            </nav>
        </div>
    </div>
</section>

<section class="product-detail category-detail-page commonPadding-120">
    <div class="container-ctn">
        <div class="product-detail__top">
            <div class="product-gallery">
                <div class="category-main-image text-center">
                    @if($category->logo)
                    <img src="{{ asset('storage/' . $category->logo) }}" alt="{{ $category->name }}" style="max-width: 100%; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
                    @else
                    <img src="{{ asset('assets/images/shop/default-cat.png') }}" alt="{{ $category->name }}" style="max-width: 100%; border-radius: 15px;">
                    @endif
                </div>
            </div>

            <div class="product-info">
                <div class="product-info__header">
                    <h2 class="product-info__title">{{ $category->name }}</h2>
                </div>

                <div class="product-actions-group">
                    <button class="btn-action btn-gradient" data-bs-toggle="modal" data-bs-target="#siteEnquiryForm">Enquire Now</button>
                    <button class="btn-action btn-outline" data-bs-toggle="modal" data-bs-target="#downloadBrochureForm">Download Brochure</button>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSetting->official_whatsapp ?? '971545864310') }}?text=I am interested in category: {{ $category->name }}."
                        class="btn-action btn-whatsapp" target="_blank">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.94 3.659 1.437 5.63 1.438h.004c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" /></svg>
                        WhatsApp Us
                    </a>
                </div>

                <div class="product-info__short-desc category-desc-rich">
                    {!! $category->description ?? ' <p>description</p>' !!}
                </div>
            </div>
        </div>

        <div class="category-listing-section mt-5">
            <div class="section-head mb-5">
                <h2 class="title" style="font-size: 32px;">Products in {{ $category->name }}</h2>
            </div>
            <div class="major-products-slider">
                @foreach($products as $p)
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
                            <a data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" role="button" class="btn-card-action btn-card-gradient">Enquire Now</a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSetting->official_whatsapp ?? '971545864310') }}" class="btn-card-action btn-card-whatsapp" target="_blank">WhatsApp</a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </div>
</section>

<style>
/* Synchronized styles for both pages */
.breadcrumb-new { margin-top: 15px; }
.breadcrumb-pill { background: #f8f9fa; display: inline-flex; align-items: center; padding: 8px 24px; border-radius: 50px; gap: 10px; font-size: 14px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
.breadcrumb-pill a { color: #666; text-decoration: none; }
.breadcrumb-pill .dot { color: #F04149; }
.breadcrumb-pill .current { color: #F04149; font-weight: 500; }

.product-info__header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
.product-info__title { font-size: 32px; font-weight: 700; margin: 0; }

.product-actions-group { display: flex; gap: 15px; margin-bottom: 30px; flex-wrap: wrap; }
.btn-action { padding: 12px 30px; border-radius: 50px; border: none; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: 0.3s; }
.btn-gradient { background: linear-gradient(90deg, #F04149 0%, #FF9700 100%); color: white; }
.btn-outline { background: transparent; border: 2px solid #F04149; color: #F04149; }
.btn-whatsapp { background: #25D366; color: white; }

/* Gradient Icon List Support for Rich Description */
.category-desc-rich ul { list-style: none; padding: 0; display: flex; flex-direction: column; gap: 20px; margin-top: 20px; }
.category-desc-rich ul li { display: flex; gap: 15px; align-items: flex-start; position: relative; padding-left: 45px; }
.category-desc-rich ul li::before {
    content: '';
    position: absolute;
    left: 0;
    top: 2px;
    width: 30px;
    height: 30px;
    background: linear-gradient(90deg, #FEB109 0%, #F14448 52.4%, #5B47C9 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-image: url('data:image/svg+xml,<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12H19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 5L19 12L12 19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>');
    background-size: 60%;
    background-repeat: no-repeat;
    background-position: center;
    box-shadow: 0 4px 10px rgba(241, 68, 72, 0.2);
}

.section-head .title { font-size: 28px; font-weight: 700; position: relative; display: inline-block; padding-bottom: 15px; }
.section-head .title::after { content: ''; position: absolute; bottom: 0; left: 0; width: 60px; height: 3px; background: #F04149; }

/* Major Products (Slider Sync) */
.product-catalog-card { 
    background: #fff; border: 1px solid #E4E8ED; border-radius: 12px; padding: 20px; 
    transition: all 0.3s ease; height: 100%; display: flex; flex-direction: column; margin: 0 10px;
}
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
.major-products-slider .slick-dots { position: relative; bottom: -40px; list-style: none; display: flex !important; justify-content: center; gap: 8px; padding: 0; }
.major-products-slider .slick-dots li { margin: 0; width: 20px; height: 8px; }
.major-products-slider .slick-dots li button { width: 100%; height: 100%; padding: 0; border-radius: 10px; background: #E4E8ED; border: none; text-indent: -9999px; }
.major-products-slider .slick-dots li.slick-active { width: 40px; }
.major-products-slider .slick-dots li.slick-active button { background: #5E47C6; }

@media (max-width: 768px) {
    .product-info__header { flex-direction: column; align-items: flex-start; gap: 15px; }
    .product-catalog-card__actions { display: none; }
    .card-arrow-link { width: 28px; height: 28px; }
}
</style>

@push('scripts')
<script>
$(document).ready(function(){
    var $catSlider = $('.major-products-slider');
    if ($catSlider.length && $catSlider.children().length > 0) {
        $catSlider.slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            dots: true,
            arrows: false,
            infinite: false,
            responsive: [
                { breakpoint: 1200, settings: { slidesToShow: 3 } },
                { breakpoint: 768, settings: { slidesToShow: 2, dots: true } },
                { breakpoint: 576, settings: { slidesToShow: 1 } }
            ]
        });
    }
});
</script>
@endpush
@endsection