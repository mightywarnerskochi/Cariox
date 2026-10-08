<style>
    .seo-page { display: grid; grid-template-columns: minmax(0, 1fr) 340px; gap: 1.5rem; align-items: start; }
    .seo-card { background: #fff; border-radius: 1rem; box-shadow: 0 4px 20px rgba(15, 23, 42, 0.06); overflow: hidden; }
    .seo-card__head { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; flex-wrap: wrap; padding: 1.5rem 1.5rem 1.25rem; border-bottom: 1px solid #e2e8f0; }
    .seo-card__title { font-size: 1.35rem; font-weight: 700; color: var(--primary-color); margin: 0 0 0.25rem; }
    .seo-card__sub { margin: 0; color: #475569; font-size: 0.9rem; }
    .seo-card__body { padding: 1.5rem; }
    .seo-badge { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.85rem; border-radius: 999px; font-size: 0.78rem; font-weight: 500; white-space: nowrap; }
    .seo-badge--ok { background: #d1fae5; color: #065f46; }
    .seo-badge--missing { background: #fee2e2; color: #991b1b; }
    .seo-info { display: flex; gap: 0.85rem; border: 3px solid var(--primary-color); border-radius: 0.6rem; background: #faf7ff; padding: 1.1rem 1.25rem; margin-bottom: 1.5rem; }
    .seo-info > i { color: var(--primary-color); font-size: 1.15rem; margin-top: 0.15rem; }
    .seo-info h4 { margin: 0 0 0.3rem; color: var(--primary-color); font-size: 1rem; font-weight: 700; }
    .seo-info p { margin: 0; color: #334155; font-size: 0.9rem; line-height: 1.55; }
    .seo-tiles { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem; }
    .seo-tile { border: 1px solid #e2e8f0; border-radius: 0.85rem; padding: 1.25rem; display: flex; flex-direction: column; gap: 1rem; }
    .seo-tile__top { display: flex; gap: 0.9rem; }
    .seo-tile__icon { flex: 0 0 44px; height: 44px; border-radius: 50%; background: #f1ecf9; color: var(--primary-color); display: flex; align-items: center; justify-content: center; }
    .seo-tile h5 { margin: 0 0 0.25rem; font-size: 1rem; font-weight: 700; color: #0f172a; }
    .seo-tile p { margin: 0; font-size: 0.86rem; color: #475569; line-height: 1.5; }
    .seo-tile form { margin: 0; margin-top: auto; }
    .seo-btn { display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; padding: 0.7rem 1rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.92rem; text-decoration: none; cursor: pointer; box-sizing: border-box; transition: opacity 0.15s, background 0.15s; margin-top: auto; }
    .seo-btn--solid { background: var(--primary-color); color: #fff; border: 1px solid var(--primary-color); box-shadow: 0 4px 12px rgba(75, 35, 130, 0.25); }
    .seo-btn--solid:hover { opacity: 0.9; color: #fff; }
    .seo-btn--outline { background: #fff; color: var(--primary-color); border: 1px solid #cbd5e1; }
    .seo-btn--outline:hover { border-color: var(--primary-color); color: var(--primary-color); }
    .seo-btn.is-disabled { opacity: 0.5; pointer-events: none; }
    .seo-side .seo-card__head { padding: 1.1rem 1.25rem; }
    .seo-side .seo-card__head h3 { margin: 0; font-size: 1.05rem; font-weight: 700; color: #0f172a; }
    .seo-side .seo-card__body { padding: 1.25rem; display: flex; flex-direction: column; gap: 0.9rem; }
    .seo-side p { margin: 0; color: #475569; font-size: 0.86rem; line-height: 1.55; }
    .seo-side .seo-meta { font-size: 0.82rem; color: #64748b; border-top: 1px dashed #e2e8f0; padding-top: 0.9rem; line-height: 1.7; }
    .seo-preview { background: #0f172a; color: #e2e8f0; border-radius: 0.6rem; padding: 1rem 1.1rem; font-family: Consolas, Monaco, monospace; font-size: 0.82rem; line-height: 1.6; white-space: pre-wrap; word-break: break-word; max-height: 320px; overflow: auto; margin: 1.5rem 0 0; }
    .seo-alert { padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; }
    .seo-alert--ok { background: #d1fae5; color: #065f46; }
    .seo-alert--error { background: #fee2e2; color: #991b1b; }
    @media (max-width: 1100px) { .seo-page { grid-template-columns: 1fr; } }
</style>
