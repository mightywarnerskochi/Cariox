<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <title>{{ $pageMeta->meta_title ?? ($siteSetting->company_name ?? 'Cariox - Industrial Automation Solutions') }}</title>
    <meta name="description" content="{{ $pageMeta->meta_description ?? 'Cariox provides cutting-edge industrial automation, marking, coding, and inspection systems for modern manufacturing.' }}">
    <meta name="keywords" content="{{ $pageMeta->meta_keywords ?? $pageMeta->meta_keyword ?? '' }}">
    
    <link rel="canonical" href="{{ $pageMeta->canonical_url ?? url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $pageMeta->og_title ?? $pageMeta->meta_title ?? $siteSetting->company_name }}">
    <meta property="og:description" content="{{ $pageMeta->og_description ?? $pageMeta->meta_description ?? '' }}">
    <meta property="og:image" content="{{ $pageMeta->og_image_url ?? $siteSetting->logo_url }}">

    <!-- Other Meta -->
    {!! $pageMeta->other_meta ?? $pageMeta->other_meta_tags ?? '' !!}

    <!-- Performance Optimizations -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://code.jquery.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ $siteSetting->favicon_url ?? asset('assets/images/fav.png') }}" type="image/png" />
    <link rel="apple-touch-icon" sizes="128x128" href="{{ $siteSetting->favicon_url ?? asset('assets/images/fav.png') }}" />

    <!-- Libraries -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" /> -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/lib/jquery.fancybox.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">

    <!-- Main Style -->
    <link rel="stylesheet" href="{{ asset('assets/scss/style.css') }}" />

    @if($siteSetting->gtm_ids)
        @foreach(explode("\n", str_replace("\r", "", $siteSetting->gtm_ids)) as $gtmId)
            @php $gtmId = trim($gtmId); @endphp
            @if($gtmId)
                <!-- Google Tag Manager -->
                <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','{{ $gtmId }}');</script>
                <!-- End Google Tag Manager -->
            @endif
        @endforeach
    @endif

    {!! $siteSetting->custom_head_scripts !!}
</head>

<body>
    @if($siteSetting->gtm_ids)
        @foreach(explode("\n", str_replace("\r", "", $siteSetting->gtm_ids)) as $gtmId)
            @php $gtmId = trim($gtmId); @endphp
            @if($gtmId)
                <!-- Google Tag Manager (noscript) -->
                <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}"
                height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
                <!-- End Google Tag Manager (noscript) -->
            @endif
        @endforeach
    @endif

    {!! $siteSetting->custom_body_scripts !!}
    
    @include('website.partials.header')

    @yield('content')

    @include('website.partials.footer')
    
    @include('website.partials.enquiry-popup')
    @include('website.partials.general-enquiry-popup')
    @include('website.partials.download-brochure-popup')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="{{ asset('assets/js/lib/jquery.fancybox.min.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
<script src="{{ asset('assets/js/lib/jquery.star-rating-svg.min.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

<script src="{{ asset('assets/js/script.js') }}" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    $(document).on('show.bs.modal', '#siteEnquiryForm', function (event) {
        var button = $(event.relatedTarget);
        var productName = button.data('product-name');
        var productId = button.data('product-id');
        var modal = $(this);
        modal.find('#product_enquiry').val(productName || '');
        modal.find('#product_id_enquiry').val(productId || '');
    });

    $(document).on('show.bs.modal', '#downloadBrochureForm', function (event) {
        var button = $(event.relatedTarget);
        var productName = button.data('product-name');
        var brochurePath = button.data('product-brochure');
        var modal = $(this);
        modal.find('#brochure_product_name').val(productName || '');
        modal.find('#product_enquiry_readonly').val(productName || '');
        modal.find('#brochure_file_path').val(brochurePath || '');
    });
});
</script>
@stack('scripts')
</body>
</html>