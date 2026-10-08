@extends('admin.layouts.app')

@section('content')
@include('admin.seo._styles')

<div class="dashboard-content">
    @if(session('success'))
        <div class="seo-alert seo-alert--ok">{{ session('success') }}</div>
    @endif

    <div class="seo-page">
        <div class="seo-card">
            <div class="seo-card__head">
                <div>
                    <h2 class="seo-card__title">Robots.txt Management</h2>
                    <p class="seo-card__sub">View and manually edit the public robots.txt file used by crawlers.</p>
                </div>
                @if($exists)
                    <span class="seo-badge seo-badge--ok"><i class="fas fa-check-circle"></i> robots.txt exists</span>
                @else
                    <span class="seo-badge seo-badge--missing"><i class="fas fa-times-circle"></i> robots.txt is missing</span>
                @endif
            </div>

            <div class="seo-card__body">
                <div class="seo-info">
                    <i class="fas fa-info-circle"></i>
                    <div>
                        <h4>Manual File Editor</h4>
                        <p>Open the current file, make direct text changes, and save it back to the public directory.</p>
                    </div>
                </div>

                <div class="seo-tiles">
                    <div class="seo-tile">
                        <div class="seo-tile__top">
                            <div class="seo-tile__icon"><i class="fas fa-pen"></i></div>
                            <div>
                                <h5>Edit Robots.txt</h5>
                                <p>Useful for allow, disallow, crawl-delay, and sitemap directives.</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.robots.edit') }}" class="seo-btn seo-btn--solid">
                            <i class="far fa-edit"></i> {{ $exists ? 'Edit Robots.txt' : 'Create Robots.txt' }}
                        </a>
                    </div>

                    <div class="seo-tile">
                        <div class="seo-tile__top">
                            <div class="seo-tile__icon"><i class="fas fa-sitemap"></i></div>
                            <div>
                                <h5>Sitemap Reference</h5>
                                <p>
                                    @if($hasSitemap)
                                        robots.txt already points crawlers to your sitemap.
                                    @else
                                        Add a <code>Sitemap:</code> line so search engines can find your generated sitemap.
                                    @endif
                                </p>
                            </div>
                        </div>
                        <form action="{{ route('admin.robots.addSitemap') }}" method="POST">
                            @csrf
                            <button type="submit" class="seo-btn seo-btn--outline {{ $hasSitemap ? 'is-disabled' : '' }}" {{ $hasSitemap ? 'disabled' : '' }}>
                                <i class="fas {{ $hasSitemap ? 'fa-check' : 'fa-plus' }}"></i> {{ $hasSitemap ? 'Sitemap Linked' : 'Add Sitemap Line' }}
                            </button>
                        </form>
                    </div>
                </div>

                @if($exists)
                    <pre class="seo-preview">{{ $content }}</pre>
                @endif
            </div>
        </div>

        <div class="seo-card seo-side">
            <div class="seo-card__head"><h3>Quick Actions</h3></div>
            <div class="seo-card__body">
                <a href="{{ url('robots.txt') }}" target="_blank" rel="noopener" class="seo-btn seo-btn--outline {{ $exists ? '' : 'is-disabled' }}">
                    <i class="fas fa-external-link-alt"></i> View Robots.txt File
                </a>
                <p>Robots.txt changes are applied immediately after saving.</p>
                <p>Keep sitemap references updated so search engines can find your generated sitemap.</p>
                @unless($sitemapExists)
                    <p style="color: #b45309;"><i class="fas fa-exclamation-triangle"></i> sitemap.xml has not been generated yet. <a href="{{ route('admin.sitemap.index') }}">Generate it</a>.</p>
                @endunless
                <div class="seo-meta">
                    <div><strong>URL:</strong> {{ url('robots.txt') }}</div>
                    <div><strong>Last updated:</strong> {{ $lastModified ? $lastModified->timezone(config('app.timezone'))->format('d M Y, h:i A') : '—' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
