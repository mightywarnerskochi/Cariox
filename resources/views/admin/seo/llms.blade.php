@extends('admin.layouts.app')

@section('content')
@include('admin.seo._styles')

<div class="dashboard-content">
    @if(session('success'))
        <div class="seo-alert seo-alert--ok">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="seo-alert seo-alert--error">{{ session('error') }}</div>
    @endif

    <div class="seo-page">
        <div class="seo-card">
            <div class="seo-card__head">
                <div>
                    <h2 class="seo-card__title">LLMs.txt Management</h2>
                    <p class="seo-card__sub">Generate and maintain an llms.txt file for AI crawlers and discovery tools.</p>
                </div>
                @if($exists)
                    <span class="seo-badge seo-badge--ok"><i class="fas fa-check-circle"></i> llms.txt exists</span>
                @else
                    <span class="seo-badge seo-badge--missing"><i class="fas fa-times-circle"></i> llms.txt is missing</span>
                @endif
            </div>

            <div class="seo-card__body">
                <div class="seo-info">
                    <i class="fas fa-info-circle"></i>
                    <div>
                        <h4>How It Works</h4>
                        <p>Automatic generation lists your main pages, product categories, products, services and blogs with short descriptions.
                            New or updated content refreshes the generated link block automatically.</p>
                    </div>
                </div>

                <div class="seo-tiles">
                    <div class="seo-tile">
                        <div class="seo-tile__top">
                            <div class="seo-tile__icon"><i class="fas fa-robot"></i></div>
                            <div>
                                <h5>Automatic Generation</h5>
                                <p>Refresh the generated link list from the active website content.</p>
                            </div>
                        </div>
                        <form action="{{ route('admin.llms.generate') }}" method="POST">
                            @csrf
                            <button type="submit" class="seo-btn seo-btn--solid">
                                <i class="fas fa-sync-alt"></i> {{ $exists ? 'Regenerate LLMs.txt' : 'Generate LLMs.txt' }}
                            </button>
                        </form>
                    </div>

                    <div class="seo-tile">
                        <div class="seo-tile__top">
                            <div class="seo-tile__icon"><i class="fas fa-pen"></i></div>
                            <div>
                                <h5>Manual Control</h5>
                                <p>Add custom notes or tune the generated link list manually.</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.llms.edit') }}" class="seo-btn seo-btn--outline {{ $exists ? '' : 'is-disabled' }}"
                           title="{{ $exists ? '' : 'Generate llms.txt first' }}">
                            <i class="far fa-edit"></i> Edit LLMs.txt
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="seo-card seo-side">
            <div class="seo-card__head"><h3>Quick Actions</h3></div>
            <div class="seo-card__body">
                <a href="{{ url('llms.txt') }}" target="_blank" rel="noopener" class="seo-btn seo-btn--outline {{ $exists ? '' : 'is-disabled' }}">
                    <i class="fas fa-external-link-alt"></i> View LLMs.txt File
                </a>
                <p>Manual content outside the generated markers is preserved during regeneration.</p>
                <p>The same content changes that update the sitemap also keep this file current.</p>
                <div class="seo-meta">
                    <div><strong>URL:</strong> {{ url('llms.txt') }}</div>
                    <div><strong>Links:</strong> {{ $exists ? $linkCount : '—' }}</div>
                    <div><strong>Last updated:</strong> {{ $lastModified ? $lastModified->timezone(config('app.timezone'))->format('d M Y, h:i A') : '—' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
