<header>
    <div class="container-ctn">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <a href="{{ url('/') }}">
                <picture>
                    <img src="{{ $siteSetting->logo ? asset('storage/' . $siteSetting->logo) : asset('assets/images/logo.png') }}" width="180" height="70" class="img-fluid" alt="{{ $siteSetting->company_name ?? 'Cariox' }}">
                </picture>
            </a>
            <nav class="d-none d-xl-block">
                <ul>
                    <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
                    <li class="{{ request()->is('about') ? 'active' : '' }}"><a href="{{ url('about') }}">About Us</a></li>
                    <li class="mega-menu-item">
                        <a href="{{ url('products') }}" class="{{ request()->is('products*') ? 'active' : '' }}">
                            Products
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <path d="M5.25 7.5L9 11.25L12.75 7.5" stroke="white" stroke-width="1.125" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                        <div class="dropdown-submenu category-mega-menu">
                            <div class="mega-menu-grid">
                                @foreach($globalCategories as $cat)
                                <div class="mega-menu-col">
                                    <h4 class="mega-menu-title">{{ $cat->name }}</h4>
                                    <ul>
                                        @if($cat->products->count() > 0)
                                            @foreach($cat->products as $product)
                                                <li>
                                                    <a href="{{ route('product-detail', $product->slug) }}">{{ $product->product_title }}</a>
                                                </li>
                                            @endforeach
                                        @else
                                            @foreach($cat->subcategories as $sub)
                                                <li><a href="{{ route('products', ['category' => $cat->slug, 'subcategory' => $sub->slug]) }}">{{ $sub->name }}</a></li>
                                            @endforeach
                                            @if($cat->subcategories->count() == 0)
                                                <li><a href="{{ route('product-category', $cat->slug) }}">View All</a></li>
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                                @endforeach
                            </div>
                            <div class="mega-menu-footer">
                                <a href="{{ url('products') }}" class="view-all-link">
                                    <span>Discover All Products</span>
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.16669 10H15.8334M15.8334 10L10 4.16669M15.8334 10L10 15.8334" stroke="white" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="{{ request()->is('services*') ? 'active' : '' }}"><a href="{{ url('services') }}">Services</a></li>
                    <li class="{{ request()->is('blogs*') ? 'active' : '' }}"><a href="{{ url('blogs') }}">Blogs</a></li>
                    <li class="{{ request()->is('contact') ? 'active' : '' }}"><a href="{{ url('contact') }}">Contact Us</a></li>
                </ul>
            </nav>
            @php
                $headerBtnUrl = $globalHeaderLink->link ?? url('products');
                $headerBtnTitle = $globalHeaderLink->title ?? 'Industrial Automation';
                $isExternalHeaderBtn = str_starts_with($headerBtnUrl, 'http://') || str_starts_with($headerBtnUrl, 'https://');
            @endphp
            <a href="{{ $headerBtnUrl }}" class="header-btn d-none d-lg-block" @if($isExternalHeaderBtn) target="_blank" rel="noopener" @endif>{{ $headerBtnTitle }}</a>

            <button class="navbar-toggler d-xl-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#burgerMenu">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 7H25M5 15H25M5 23H25" stroke="white" stroke-width="2" stroke-linecap="round" />
                </svg>
            </button>
        </div>
    </div>
</header>