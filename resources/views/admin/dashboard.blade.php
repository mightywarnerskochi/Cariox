@extends('admin.layouts.app')

@php
    $hour = now()->hour;
    $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
    $adminName = strtok(auth('admin')->user()->name, ' ');

    $stats = [
        ['label' => 'Total Products', 'value' => $counts['products'], 'icon' => 'fa-box-open', 'tone' => 'amber', 'route' => 'admin.product.index'],
        ['label' => 'Total Brands', 'value' => $counts['brands'], 'icon' => 'fa-tags', 'tone' => 'coral', 'route' => 'admin.brand.index'],
        ['label' => 'Total Services', 'value' => $counts['services'], 'icon' => 'fa-concierge-bell', 'tone' => 'magenta', 'route' => 'admin.service.index'],
        ['label' => 'Testimonials', 'value' => $counts['testimonials'], 'icon' => 'fa-comment-dots', 'tone' => 'violet', 'route' => 'admin.testimonial.index'],
    ];

    $summary = [
        ['label' => 'Categories', 'value' => $counts['categories'], 'icon' => 'fa-sitemap', 'route' => 'admin.category.index'],
        ['label' => 'Subcategories', 'value' => $counts['subcategories'], 'icon' => 'fa-list', 'route' => 'admin.subcategory.index'],
        ['label' => 'Blogs', 'value' => $counts['blogs'], 'icon' => 'fa-blog', 'route' => 'admin.blog.index'],
        ['label' => 'Enquiries', 'value' => $counts['form_datas'], 'icon' => 'fa-file-alt', 'route' => 'admin.form_data.index'],
        ['label' => 'Newsletter', 'value' => $counts['newsletters'], 'icon' => 'fa-envelope-open-text', 'route' => 'admin.newsletter.index'],
        ['label' => 'Contacts', 'value' => $counts['contacts'], 'icon' => 'fa-address-book', 'route' => 'admin.contact.index'],
    ];

    $actions = [
        ['label' => 'Add Product', 'icon' => 'fa-plus', 'route' => 'admin.product.create'],
        ['label' => 'Write a Blog', 'icon' => 'fa-pen-nib', 'route' => 'admin.blog.create'],
        ['label' => 'Add Testimonial', 'icon' => 'fa-comment-medical', 'route' => 'admin.testimonial.create'],
        ['label' => 'Site Information', 'icon' => 'fa-cog', 'route' => 'admin.settings.info'],
    ];
@endphp

@push('styles')
<style>
    .cx-dash {
        --cx-amber: #f7a600;
        --cx-orange: #f05a28;
        --cx-coral: #e5304f;
        --cx-magenta: #b0307f;
        --cx-violet: #6050c0;
        --cx-gradient: linear-gradient(115deg, #f7a600 0%, #f05a28 28%, #e5304f 52%, #b0307f 76%, #6050c0 100%);
        --cx-ink: #1e1b2e;
        --cx-muted: #6b6880;
        --cx-line: #ece9f3;
        animation: fadeIn 0.5s ease-out;
    }

    /* Welcome banner */
    .cx-hero {
        position: relative;
        overflow: hidden;
        border-radius: 1.25rem;
        padding: 2rem 2.25rem;
        background: var(--cx-gradient);
        color: #fff;
        box-shadow: 0 18px 40px -18px rgba(229, 48, 79, 0.55);
        margin-bottom: 1.75rem;
    }
    .cx-hero::before,
    .cx-hero::after {
        content: "";
        position: absolute;
        width: 46px;
        height: 340px;
        border-radius: 23px;
        background: rgba(255, 255, 255, 0.12);
        top: -70px;
        right: 120px;
        transform: rotate(38deg);
    }
    .cx-hero::after { transform: rotate(-38deg); right: 120px; }
    .cx-hero__date {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        background: rgba(255, 255, 255, 0.18);
        padding: 0.35rem 0.8rem;
        border-radius: 999px;
    }
    .cx-hero h1 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0.9rem 0 0.35rem;
        color: #fff;
    }
    .cx-hero p { margin: 0; opacity: 0.92; max-width: 560px; }
    .cx-hero__actions { position: relative; z-index: 1; display: flex; gap: 0.75rem; margin-top: 1.5rem; flex-wrap: wrap; }
    .cx-hero__btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.15rem;
        border-radius: 0.65rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        transition: transform 0.2s, background-color 0.2s;
    }
    .cx-hero__btn--solid { background: #fff; color: var(--cx-coral); }
    .cx-hero__btn--ghost { background: rgba(255, 255, 255, 0.16); color: #fff; border: 1px solid rgba(255, 255, 255, 0.45); }
    .cx-hero__btn:hover { transform: translateY(-2px); }
    .cx-hero__btn--solid:hover { color: var(--cx-magenta); }
    .cx-hero__btn--ghost:hover { background: rgba(255, 255, 255, 0.26); color: #fff; }

    /* Stat cards */
    .cx-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem; margin-bottom: 1.75rem; }
    .cx-stat {
        --tone: var(--cx-coral);
        position: relative;
        display: flex;
        align-items: center;
        gap: 1.1rem;
        padding: 1.4rem 1.4rem 1.4rem 1.5rem;
        background: #fff;
        border: 1px solid var(--cx-line);
        border-radius: 1rem;
        text-decoration: none;
        color: inherit;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .cx-stat::before {
        content: "";
        position: absolute;
        inset: 0 auto 0 0;
        width: 4px;
        background: var(--tone);
    }
    .cx-stat:hover { transform: translateY(-4px); box-shadow: 0 16px 30px -18px var(--tone); color: inherit; }
    .cx-stat--amber { --tone: var(--cx-amber); --tone-2: var(--cx-orange); }
    .cx-stat--coral { --tone: var(--cx-coral); --tone-2: var(--cx-orange); }
    .cx-stat--magenta { --tone: var(--cx-magenta); --tone-2: var(--cx-coral); }
    .cx-stat--violet { --tone: var(--cx-violet); --tone-2: var(--cx-magenta); }
    .cx-stat__icon {
        flex: none;
        width: 56px;
        height: 56px;
        border-radius: 0.9rem;
        display: grid;
        place-items: center;
        font-size: 1.35rem;
        color: #fff;
        background: linear-gradient(135deg, var(--tone-2), var(--tone));
        box-shadow: 0 10px 20px -10px var(--tone);
    }
    .cx-stat__label { display: block; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.07em; text-transform: uppercase; color: var(--cx-muted); }
    .cx-stat__value { display: block; font-size: 2rem; font-weight: 700; line-height: 1.15; color: var(--cx-ink); }
    .cx-stat__go { margin-left: auto; color: #c9c5d6; transition: color 0.2s, transform 0.2s; }
    .cx-stat:hover .cx-stat__go { color: var(--tone); transform: translateX(3px); }

    /* Panels */
    .cx-grid { display: grid; grid-template-columns: minmax(0, 2fr) minmax(0, 1fr); gap: 1.25rem; margin-bottom: 1.25rem; }
    .cx-panel { background: #fff; border: 1px solid var(--cx-line); border-radius: 1rem; padding: 1.5rem; }
    .cx-panel__head { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1.25rem; }
    .cx-panel__title { display: flex; align-items: center; gap: 0.6rem; font-size: 1.1rem; font-weight: 700; color: var(--cx-ink); margin: 0; }
    .cx-panel__title::before { content: ""; width: 4px; height: 1.1rem; border-radius: 2px; background: var(--cx-gradient); }
    .cx-panel__link { font-size: 0.8rem; font-weight: 600; color: var(--cx-coral); text-decoration: none; }
    .cx-panel__link:hover { color: var(--cx-magenta); }

    .cx-summary { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 0.9rem; }
    .cx-tile {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 1rem;
        border-radius: 0.85rem;
        background: #faf8fd;
        border: 1px solid var(--cx-line);
        text-decoration: none;
        color: inherit;
        transition: border-color 0.2s, background-color 0.2s;
    }
    .cx-tile:hover { border-color: #f3b4c0; background: #fff6f7; color: inherit; }
    .cx-tile__icon {
        width: 40px;
        height: 40px;
        border-radius: 0.7rem;
        display: grid;
        place-items: center;
        background: #fff;
        color: var(--cx-coral);
        box-shadow: 0 2px 6px rgba(30, 27, 46, 0.06);
    }
    .cx-tile__label { display: block; font-size: 0.72rem; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; color: var(--cx-muted); }
    .cx-tile__value { display: block; font-size: 1.4rem; font-weight: 700; color: var(--cx-ink); line-height: 1.2; }

    .cx-actions { display: flex; flex-direction: column; gap: 0.7rem; }
    .cx-action {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.8rem 1rem;
        border-radius: 0.75rem;
        border: 1px solid var(--cx-line);
        color: var(--cx-ink);
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.2s;
    }
    .cx-action i:first-child { width: 32px; height: 32px; border-radius: 0.55rem; display: grid; place-items: center; background: #fff1ec; color: var(--cx-orange); }
    .cx-action .fa-arrow-right { margin-left: auto; font-size: 0.8rem; color: #c9c5d6; }
    .cx-action:hover { border-color: transparent; background: #faf8fd; box-shadow: 0 8px 18px -12px rgba(176, 48, 127, 0.6); color: var(--cx-magenta); }
    .cx-action--primary { background: var(--cx-gradient); border: none; color: #fff; }
    .cx-action--primary i:first-child { background: rgba(255, 255, 255, 0.2); color: #fff; }
    .cx-action--primary .fa-arrow-right { color: rgba(255, 255, 255, 0.8); }
    .cx-action--primary:hover { color: #fff; background: var(--cx-gradient); filter: brightness(1.05); }

    /* Recent lists */
    .cx-list { list-style: none; margin: 0; padding: 0; }
    .cx-list li { display: flex; align-items: center; gap: 0.9rem; padding: 0.75rem 0; border-top: 1px solid var(--cx-line); }
    .cx-list li:first-child { border-top: none; padding-top: 0; }
    .cx-thumb {
        flex: none;
        width: 46px;
        height: 46px;
        border-radius: 0.65rem;
        border: 1px solid var(--cx-line);
        background: #faf8fd center / contain no-repeat;
        display: grid;
        place-items: center;
        color: #c9c5d6;
    }
    .cx-initial {
        flex: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        color: #fff;
        font-weight: 700;
        background: linear-gradient(135deg, var(--cx-orange), var(--cx-magenta));
    }
    .cx-list__main { min-width: 0; flex: 1; }
    .cx-list__title { display: block; font-weight: 600; color: var(--cx-ink); text-decoration: none; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    a.cx-list__title:hover { color: var(--cx-coral); }
    .cx-list__meta { display: block; font-size: 0.8rem; color: var(--cx-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .cx-badge { flex: none; font-size: 0.7rem; font-weight: 600; padding: 0.25rem 0.6rem; border-radius: 999px; }
    .cx-badge--on { background: #fff1ec; color: var(--cx-orange); }
    .cx-badge--off { background: #f1f0f5; color: var(--cx-muted); }
    .cx-time { flex: none; font-size: 0.75rem; color: var(--cx-muted); }
    .cx-empty { text-align: center; padding: 1.5rem 0.5rem; color: var(--cx-muted); font-size: 0.9rem; }
    .cx-empty i { display: block; font-size: 1.6rem; margin-bottom: 0.5rem; background: var(--cx-gradient); -webkit-background-clip: text; background-clip: text; color: transparent; }

    @media (max-width: 1100px) {
        .cx-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
        .cx-hero { padding: 1.5rem; }
        .cx-hero h1 { font-size: 1.5rem; }
        .cx-summary { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
</style>
@endpush

@section('content')
<div class="cx-dash">

    <section class="cx-hero">
        <span class="cx-hero__date"><i class="far fa-calendar"></i> {{ now()->format('l, j F Y') }}</span>
        <h1>{{ $greeting }}, {{ $adminName }}</h1>
        <p>Here is what is happening across the Cariox website today.</p>
        <div class="cx-hero__actions">
            <a href="{{ route('admin.product.create') }}" class="cx-hero__btn cx-hero__btn--solid"><i class="fas fa-plus"></i> Add Product</a>
            <a href="{{ url('/') }}" target="_blank" rel="noopener noreferrer" class="cx-hero__btn cx-hero__btn--ghost"><i class="fas fa-external-link-alt"></i> Visit Site</a>
        </div>
    </section>

    <div class="cx-stats">
        @foreach($stats as $stat)
            <a href="{{ route($stat['route']) }}" class="cx-stat cx-stat--{{ $stat['tone'] }}">
                <span class="cx-stat__icon"><i class="fas {{ $stat['icon'] }}"></i></span>
                <span>
                    <span class="cx-stat__label">{{ $stat['label'] }}</span>
                    <span class="cx-stat__value">{{ number_format($stat['value']) }}</span>
                </span>
                <i class="fas fa-chevron-right cx-stat__go"></i>
            </a>
        @endforeach
    </div>

    <div class="cx-grid">
        <section class="cx-panel">
            <div class="cx-panel__head">
                <h2 class="cx-panel__title">Content Summary</h2>
            </div>
            <div class="cx-summary">
                @foreach($summary as $item)
                    <a href="{{ route($item['route']) }}" class="cx-tile">
                        <span class="cx-tile__icon"><i class="fas {{ $item['icon'] }}"></i></span>
                        <span>
                            <span class="cx-tile__label">{{ $item['label'] }}</span>
                            <span class="cx-tile__value">{{ number_format($item['value']) }}</span>
                        </span>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="cx-panel">
            <div class="cx-panel__head">
                <h2 class="cx-panel__title">Quick Actions</h2>
            </div>
            <div class="cx-actions">
                @foreach($actions as $i => $action)
                    <a href="{{ route($action['route']) }}" class="cx-action {{ $i === 0 ? 'cx-action--primary' : '' }}">
                        <i class="fas {{ $action['icon'] }}"></i> {{ $action['label'] }}
                        <i class="fas fa-arrow-right"></i>
                    </a>
                @endforeach
            </div>
        </section>
    </div>

    <div class="cx-grid">
        <section class="cx-panel">
            <div class="cx-panel__head">
                <h2 class="cx-panel__title">Recently Added Products</h2>
                <a href="{{ route('admin.product.index') }}" class="cx-panel__link">View all <i class="fas fa-arrow-right"></i></a>
            </div>
            @if($recentProducts->isEmpty())
                <div class="cx-empty"><i class="fas fa-box-open"></i>No products yet.</div>
            @else
                <ul class="cx-list">
                    @foreach($recentProducts as $product)
                        @php $image = optional($product->images->first())->image; @endphp
                        <li>
                            <span class="cx-thumb" @if($image) style="background-image: url('{{ Storage::url($image) }}')" @endif>
                                @unless($image)<i class="fas fa-image"></i>@endunless
                            </span>
                            <span class="cx-list__main">
                                <a href="{{ route('admin.product.edit', $product->id) }}" class="cx-list__title">{{ $product->product_title }}</a>
                                <span class="cx-list__meta">
                                    {{ optional($product->category)->name ?? 'Uncategorised' }}@if($product->brand) &middot; {{ $product->brand->name }}@endif
                                </span>
                            </span>
                            <span class="cx-badge {{ $product->status ? 'cx-badge--on' : 'cx-badge--off' }}">{{ $product->status ? 'Active' : 'Hidden' }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section class="cx-panel">
            <div class="cx-panel__head">
                <h2 class="cx-panel__title">Latest Enquiries</h2>
                <a href="{{ route('admin.form_data.index') }}" class="cx-panel__link">View all <i class="fas fa-arrow-right"></i></a>
            </div>
            @if($recentEnquiries->isEmpty())
                <div class="cx-empty"><i class="fas fa-inbox"></i>No enquiries yet. New website form submissions will appear here.</div>
            @else
                <ul class="cx-list">
                    @foreach($recentEnquiries as $enquiry)
                        <li>
                            <span class="cx-initial">{{ strtoupper(mb_substr($enquiry->name ?: '?', 0, 1)) }}</span>
                            <span class="cx-list__main">
                                <span class="cx-list__title">{{ $enquiry->name ?: 'Unknown' }}</span>
                                <span class="cx-list__meta">{{ $enquiry->product_name ?: ($enquiry->email ?: $enquiry->phone) }}</span>
                            </span>
                            <span class="cx-time">{{ optional($enquiry->created_at)->diffForHumans(null, true) }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </div>
</div>
@endsection
