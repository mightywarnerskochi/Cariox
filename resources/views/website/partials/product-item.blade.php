@forelse($products as $product)
<article class="product-catalog-card">
    <div class="product-catalog-card__image">
         <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->image) : asset('assets/images/shop/1.png') }}" alt="{{ $product->product_title }}">
    </div>
    <div class="product-catalog-card__content">
        <h3>{{ $product->product_title }}</h3>
        <p>{{ $product->sub_title }}</p>
        <div class="product-catalog-card__actions">
            <a data-bs-toggle="modal" data-bs-target="#siteEnquiryForm" role="button"
                aria-label="Open enquiry form" data-product-name="{{ $product->product_title }}" data-product-id="{{ $product->id }}"
                class="product-catalog-card__cta product-catalog-card__cta--primary">Enquire Now</a>
            <a href="https://wa.me/{{ $whatsappNumber ?? '971545864310' }}?text=I am interested in {{ $product->product_title }}."
                target="_blank" rel="noopener"
                class="product-catalog-card__cta product-catalog-card__cta--secondary">WhatsApp Us</a>
            <a href="{{ route('product-detail', $product->slug) }}" class="product-catalog-card__arrow"
                aria-label="View {{ $product->product_title }} details">
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34" fill="none">
                    <path d="M11.3136 22.6274L22.6273 11.3137M22.6273 11.3137V19.799M22.6273 11.3137H14.142" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    </div>
</article>
@empty
<div class="col-12 text-center py-5 no-products">
    <p>No products found matching your criteria.</p>
</div>
@endforelse
