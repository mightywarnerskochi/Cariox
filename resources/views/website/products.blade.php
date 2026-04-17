@extends('website.layouts.app')

@section('content')
<?php
$page_title = 'Products | Cariox';
$page_desc = 'Explore industrial coding, inspection, and packaging systems from Cariox Technologies.';

?>
<div class="inner-vector">
    <picture><img src="{{ asset('assets/images/inner/inner-vector.png') }}" alt="About Us"></picture>
</div>
<section class="inner-banner products-banner">
    <div class="container-ctn w-100">
        <div class="content">
            <h1 class="title">Products</h1>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path
                            d="M12 12.75H6M2.25 8.9925V10.875C2.25 13.35 2.25 14.5875 3.01875 15.3563C3.7875 16.125 5.025 16.125 7.5 16.125H10.5C12.975 16.125 14.2125 16.125 14.9813 15.3563C15.75 14.5875 15.75 13.35 15.75 10.875V8.9925C15.75 7.731 15.75 7.101 15.483 6.555C15.216 6.009 14.718 5.622 13.7235 4.848L12.2235 3.68175C10.6748 2.47725 9.9 1.875 9 1.875C8.1 1.875 7.32525 2.47725 5.7765 3.68175L4.2765 4.848C3.28125 5.622 2.784 6.009 2.517 6.555C2.25 7.101 2.25 7.731 2.25 8.9925Z"
                            stroke="black" stroke-width="1.125" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Home
                </a>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M4.5 10.125H7.875V11.25H4.5V10.125ZM4.5 12.375H10.125V13.5H4.5V12.375Z"
                            fill="#F04149" />
                        <path
                            d="M14.625 2.25H3.375C3.07677 2.25045 2.79088 2.36912 2.58 2.58C2.36912 2.79088 2.25045 3.07677 2.25 3.375V14.625C2.25045 14.9232 2.36912 15.2091 2.58 15.42C2.79088 15.6309 3.07677 15.7496 3.375 15.75H14.625C14.9232 15.7496 15.2091 15.6309 15.42 15.42C15.6309 15.2091 15.7496 14.9232 15.75 14.625V3.375C15.7496 3.07677 15.6309 2.79088 15.42 2.58C15.2091 2.36912 14.9232 2.25045 14.625 2.25ZM10.125 3.375V5.625H7.875V3.375H10.125ZM3.375 14.625V3.375H6.75V6.75H11.25V3.375H14.625L14.6256 14.625H3.375Z"
                            fill="#F04149" />
                    </svg>
                    Products
                </span>
            </nav>
        </div>
    </div>
</section>

<!-- Sidebar overlay backdrop -->
<div class="product-sidebar-overlay" id="productSidebarOverlay" aria-hidden="true"></div>

<section class="product-listing commonPadding-120">
    <div class="container-ctn">
        <div class="product-listing__layout justify-content-between">
            <aside class="product-sidebar" id="productSidebarDrawer" aria-label="Product filters">
                <form id="filterForm" action="{{ route('products') }}" method="GET">
                    <button class="product-sidebar__close" id="productSidebarClose" aria-label="Close filters">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>


                    <div class="product-sidebar__panel">
                        <h3>Categories</h3>
                        <div class="product-sidebar__panel-body">
                            <div class="product-sidebar__group">
                                <div class="accordion product-sidebar__main-accordion" id="productSidebarMainAccordion">
                                    @foreach($categories as $category)
                                    @php
                                        $isCategoryActive = (isset(request()->category) && in_array($category->slug, (array)request()->category)) || 
                                                           $category->subcategories->whereIn('slug', (array)request()->subcategory)->count() > 0 ||
                                                           $category->subcategories->flatMap->products->whereIn('slug', (array)request()->product)->count() > 0;
                                    @endphp
                                    <div class="accordion-item product-sidebar__main-item">
                                        <h4 class="accordion-header" id="productSidebarHeading{{ $category->id }}">
                                            <button class="accordion-button product-sidebar__main-link {{ $isCategoryActive ? '' : 'collapsed' }}" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#productSidebarCat{{ $category->id }}"
                                                aria-expanded="{{ $isCategoryActive ? 'true' : 'false' }}" aria-controls="productSidebarCat{{ $category->id }}">
                                                <span>{{ $category->name }}</span>
                                            </button>
                                        </h4>
                                        <div id="productSidebarCat{{ $category->id }}" class="accordion-collapse collapse {{ $isCategoryActive ? 'show' : '' }}"
                                            aria-labelledby="productSidebarHeading{{ $category->id }}"
                                            data-bs-parent="#productSidebarMainAccordion">
                                            <div class="accordion-body product-sidebar__main-body">
                                                @if($category->subcategories->count() > 0)
                                                <div class="accordion product-sidebar__sub-accordion" id="productSidebarSubAccordion{{ $category->id }}">
                                                    @foreach($category->subcategories as $sub)
                                                    @php
                                                        $isSubActive = in_array($sub->slug, (array)request()->subcategory) || 
                                                                      $sub->products->whereIn('slug', (array)request()->product)->count() > 0;
                                                    @endphp
                                                    <div class="accordion-item product-sidebar__sub-item">
                                                        <h5 class="accordion-header" id="productSidebarSubHeading{{ $sub->id }}">
                                                            <button class="accordion-button product-sidebar__sub-link {{ $isSubActive ? '' : 'collapsed' }}" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#productSidebarSub{{ $sub->id }}"
                                                                aria-expanded="{{ $isSubActive ? 'true' : 'false' }}" aria-controls="productSidebarSub{{ $sub->id }}">
                                                                <span>{{ $sub->name }}</span>
                                                            </button>
                                                        </h5>
                                                        <div id="productSidebarSub{{ $sub->id }}" class="accordion-collapse collapse {{ $isSubActive ? 'show' : '' }}"
                                                            aria-labelledby="productSidebarSubHeading{{ $sub->id }}"
                                                            data-bs-parent="#productSidebarSubAccordion{{ $category->id }}">
                                                            <div class="accordion-body product-sidebar__sub-body">
                                                                @foreach($sub->products as $p)
                                                                <label class="product-sidebar__option">
                                                                    <input type="checkbox" name="product[]" value="{{ $p->slug }}" {{ in_array($p->slug, (array)request()->product) ? 'checked' : '' }}>
                                                                    <span class="product-sidebar__check"></span>
                                                                    <span class="product-sidebar__label">{{ $p->product_title }}</span>
                                                                </label>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @else
                                                    <div class="product-sidebar__nested">
                                                        <label class="product-sidebar__option">
                                                            <input type="checkbox" name="category[]" value="{{ $category->slug }}" {{ in_array($category->slug, (array)request()->category) ? 'checked' : '' }}>
                                                            <span class="product-sidebar__check"></span>
                                                            <span class="product-sidebar__label">All {{ $category->name }}</span>
                                                        </label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="product-sidebar__panel mt-2">
                        <h3>Brands</h3>
                        <div class="product-sidebar__panel-body">
                            <div class="product-sidebar__brands">
                                @foreach($brands as $brand)
                                <label class="product-sidebar__brand">
                                    <input type="checkbox" name="brand[]" value="{{ $brand->slug }}" {{ in_array($brand->slug, (array)request()->brand) ? 'checked' : '' }}>
                                    <span class="product-sidebar__brand-mark" aria-hidden="true"></span>
                                    @if($brand->image)
                                    <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}" width="86" height="36">
                                    @else
                                    <span>{{ $brand->name }}</span>
                                    @endif
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </form>
            </aside>

            <div class="product-catalog">
                <div class="product-catalog__grid" id="productGrid">
                    @include('website.partials.product-item', ['products' => $products])
                </div>

                {{-- Loader --}}
                <div id="productLoader" class="text-center py-4" style="display: none;">
                    <div class="spinner-border text-danger" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                {{-- Load More Sentinel --}}
                <div id="loadMoreSentinel" style="height: 10px;"></div>

                {{-- Standard pagination (hidden, used for fallback data) --}}
                <div class="pagination-wrapper mt-5 d-none" id="standardPagination">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    let isLoading = false;
    let hasMore = {{ $products->hasMorePages() ? 'true' : 'false' }};
    const productGrid = document.getElementById('productGrid');
    const filterForm = document.getElementById('filterForm');
    const loader = document.getElementById('productLoader');
    const sentinel = document.getElementById('loadMoreSentinel');

    // Function to fetch products
    async function fetchProducts(reset = false) {
        if (isLoading) return;
        if (!reset && !hasMore) return;

        isLoading = true;
        if (reset) {
            currentPage = 1;
            productGrid.style.opacity = '0.5';
        }
        loader.style.display = 'block';

        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData);
        params.append('page', currentPage + (reset ? 0 : 1));

        try {
            const response = await fetch(`{{ route('products') }}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();

            if (reset) {
                productGrid.innerHTML = data.html;
                productGrid.style.opacity = '1';
                currentPage = 1;
            } else {
                // Append new items
                if (data.html) {
                    // Check if "No products found" is currently displayed and remove it if we have new items
                    const noProducts = productGrid.querySelector('.no-products');
                    if (noProducts) noProducts.remove();
                    
                    productGrid.insertAdjacentHTML('beforeend', data.html);
                }
                currentPage++;
            }

            hasMore = data.hasMore;
            
            // Update URL without reloading
            const newUrl = window.location.pathname + '?' + params.toString();
            window.history.pushState({ path: newUrl }, '', newUrl);

        } catch (error) {
            console.error('Error fetching products:', error);
        } finally {
            isLoading = false;
            loader.style.display = 'none';
        }
    }

    // Filter change handler
    filterForm.querySelectorAll('input[type="checkbox"]').forEach(input => {
        input.addEventListener('change', () => {
            fetchProducts(true);
        });
    });

    // Infinite scroll using Intersection Observer
    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting && hasMore && !isLoading) {
            fetchProducts();
        }
    }, {
        rootMargin: '200px'
    });
    observer.observe(sentinel);
});
</script>
@endsection