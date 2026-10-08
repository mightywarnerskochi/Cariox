@extends('admin.layouts.app')

@section('content')
<style>
    .sitemap-wrap { display: flex; justify-content: center; padding: 1rem 0 2rem; }
    .sitemap-card { width: 100%; max-width: 650px; background: #fff; border-radius: 1.5rem; box-shadow: 0 10px 40px rgba(15, 23, 42, 0.08); padding: 2.5rem; box-sizing: border-box; }
    .sitemap-card__head { display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; }
    .sitemap-card__title { font-size: 1.85rem; font-weight: 700; color: #0f172a; margin: 0; }
    .sitemap-btn-view { display: inline-flex; align-items: center; gap: 0.5rem; background: #334155; color: #fff; padding: 0.75rem 1.1rem; border-radius: 0.6rem; font-weight: 600; font-size: 0.9rem; text-decoration: none; box-shadow: 0 4px 12px rgba(51, 65, 85, 0.25); transition: background 0.2s; }
    .sitemap-btn-view:hover { background: #1e293b; color: #fff; }
    .sitemap-btn-view.is-disabled { opacity: 0.5; pointer-events: none; }
    .sitemap-status { display: flex; justify-content: center; margin: 1.5rem 0 0.5rem; }
    .sitemap-status span { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.55rem 1.1rem; border-radius: 999px; font-size: 0.9rem; font-weight: 500; }
    .sitemap-status .is-ok { background: #d1fae5; color: #065f46; }
    .sitemap-status .is-missing { background: #fee2e2; color: #991b1b; }
    .sitemap-meta { text-align: center; color: #94a3b8; font-size: 0.8rem; margin-bottom: 1.5rem; }
    .sitemap-desc { text-align: center; color: #475569; font-size: 0.92rem; line-height: 1.6; margin: 0 0 2rem; }
    .sitemap-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
    .sitemap-actions form { margin: 0; }
    .sitemap-btn-main { display: flex; align-items: center; justify-content: center; gap: 0.6rem; width: 100%; height: 52px; border: none; border-radius: 0.75rem; color: #fff; font-weight: 600; font-size: 1rem; cursor: pointer; text-decoration: none; transition: transform 0.15s, box-shadow 0.15s; box-sizing: border-box; }
    .sitemap-btn-main:hover { transform: translateY(-1px); color: #fff; }
    .sitemap-btn-main--purple { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 6px 18px rgba(118, 75, 162, 0.3); }
    .sitemap-btn-main--orange { background: linear-gradient(135deg, #f6ad55 0%, #e8590c 100%); box-shadow: 0 6px 18px rgba(232, 89, 12, 0.3); }
    .sitemap-btn-main[disabled], .sitemap-btn-main.is-disabled { opacity: 0.5; cursor: not-allowed; pointer-events: none; }
    .sitemap-tools { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-top: 1rem; padding: 0.75rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.75rem; }
    .sitemap-btn-tool { display: flex; align-items: center; justify-content: center; gap: 0.6rem; height: 46px; background: #fff; border: 1px solid #e2e8f0; border-radius: 0.6rem; color: #1e293b; font-weight: 600; font-size: 0.92rem; text-decoration: none; transition: border-color 0.15s, color 0.15s; }
    .sitemap-btn-tool:hover { border-color: #667eea; color: #4c51bf; }
    .sitemap-btn-tool .count { background: #eef2ff; color: #4c51bf; border-radius: 999px; padding: 0 0.5rem; font-size: 0.75rem; line-height: 1.5; }
    @media (max-width: 560px) {
        .sitemap-card { padding: 1.5rem; }
        .sitemap-card__title { font-size: 1.5rem; }
        .sitemap-actions, .sitemap-tools { grid-template-columns: 1fr; }
    }
</style>

<div class="dashboard-content">
    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin: 0 auto 1.5rem; max-width: 650px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background-color: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin: 0 auto 1.5rem; max-width: 650px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="sitemap-wrap">
        <div class="sitemap-card">
            <div class="sitemap-card__head">
                <h2 class="sitemap-card__title">Sitemap Management</h2>
                <a href="{{ url('sitemap.xml') }}" target="_blank" rel="noopener" class="sitemap-btn-view {{ $exists ? '' : 'is-disabled' }}">
                    View Sitemap <i class="far fa-eye"></i>
                </a>
            </div>

            <div class="sitemap-status">
                @if($exists)
                    <span class="is-ok"><i class="fas fa-check-circle"></i> sitemap.xml exists</span>
                @else
                    <span class="is-missing"><i class="fas fa-times-circle"></i> sitemap.xml is missing</span>
                @endif
            </div>
            <div class="sitemap-meta">
                @if($exists)
                    {{ $urlCount }} URLs &middot; Last updated {{ $lastModified->timezone(config('app.timezone'))->format('d M Y, h:i A') }}
                @else
                    Generate the sitemap to publish it at {{ url('sitemap.xml') }}
                @endif
            </div>

            <p class="sitemap-desc">
                Automatically generate and update your sitemap to improve SEO. The system already
                monitors content changes, but you can manually trigger a full crawl here.
            </p>

            <div class="sitemap-actions">
                <form action="{{ route('admin.sitemap.generate') }}" method="POST">
                    @csrf
                    <button type="submit" class="sitemap-btn-main sitemap-btn-main--purple">
                        {{ $exists ? 'Regenerate Sitemap' : 'Generate Sitemap' }} <i class="fas fa-sync-alt"></i>
                    </button>
                </form>
                <a href="{{ route('admin.sitemap.edit') }}" class="sitemap-btn-main sitemap-btn-main--orange {{ $exists ? '' : 'is-disabled' }}"
                   title="{{ $exists ? 'Edit sitemap.xml manually' : 'Generate the sitemap first' }}">
                    Edit Manual <i class="far fa-edit"></i>
                </a>
            </div>

            <div class="sitemap-tools">
                <a href="{{ route('admin.redirects.index') }}" class="sitemap-btn-tool">
                    <i class="fas fa-exchange-alt"></i> URL redirects
                    @if($redirectCount)<span class="count">{{ $redirectCount }}</span>@endif
                </a>
                <a href="{{ route('admin.not_found.index') }}" class="sitemap-btn-tool">
                    <i class="far fa-file-alt"></i> 404 log
                    @if($notFoundCount)<span class="count">{{ $notFoundCount }}</span>@endif
                </a>
            </div>
        </div>
    </div>
</div>
@stop
