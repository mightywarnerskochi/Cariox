<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // One instance per request so uploads staged for replacement can be cleaned up if never saved
        $this->app->singleton(\App\Services\MediaStorage::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Keep sitemap.xml and llms.txt in sync with the content that appears in them
        foreach ([\App\Models\Product::class, \App\Models\Category::class, \App\Models\Service::class, \App\Models\Blog::class] as $model) {
            $model::saved(fn () => \App\Services\SeoFileSync::queue());
            $model::deleted(fn () => \App\Services\SeoFileSync::queue());
        }

        if (!app()->runningInConsole()) {
            try {
                $siteSetting = \App\Models\SiteSetting::first() ?? \App\Models\SiteSetting::create(['name' => 'Cariox']);
                \Illuminate\Support\Facades\View::share('siteSetting', $siteSetting);

                $globalCategories = \App\Models\Category::with([
                    'subcategories' => function($q) {
                        $q->where('status', 1)->orderBy('position');
                    },
                    'products' => function ($q) {
                        $q->where('status', 1)
                            ->whereNotNull('category_id')
                            ->orderBy('position');
                    }
                ])->where('status', 1)->orderBy('position')->get();
                \Illuminate\Support\Facades\View::share('globalCategories', $globalCategories);

                $globalContacts = \App\Models\Contact::with(['phones', 'emails'])->where('status', 1)->orderBy('order')->get();
                \Illuminate\Support\Facades\View::share('globalContacts', $globalContacts);

                $globalHeaderLink = \App\Models\HeaderLink::where('status', 1)->orderBy('order')->first();
                \Illuminate\Support\Facades\View::share('globalHeaderLink', $globalHeaderLink);

                // Fall back to the site settings number; stays empty when no WhatsApp number is configured
                $whatsappNumber = preg_replace('/[^0-9]/', '', $siteSetting->official_whatsapp ?? '');
                foreach($globalContacts as $c) {
                    foreach($c->phones as $p) {
                        if ($p->is_whatsapp) {
                            $whatsappNumber = preg_replace('/[^0-9]/', '', $p->phone_number);
                            break 2;
                        }
                    }
                }
                \Illuminate\Support\Facades\View::share('whatsappNumber', $whatsappNumber);

                // SEO Metadata View Composer
                \Illuminate\Support\Facades\View::composer('website.layouts.app', function ($view) {
                    $routeName = request()->route() ? request()->route()->getName() : null;
                    $metadata = null;

                    if ($routeName) {
                        $metadata = \App\Models\PageMetadata::where('page_name', $routeName)->first();
                    }

                    $data = $view->getData();
                    $dynamicMeta = null;

                    // Only detail routes use record-level meta. Listing pages also expose loop
                    // variables such as $product or $service to the layout, which must be ignored.
                    if ($routeName === 'product-detail' && isset($data['product']) && $data['product'] instanceof \App\Models\Product) {
                        $dynamicMeta = $data['product']->meta;
                    } elseif ($routeName === 'service-detail' && isset($data['service']) && $data['service'] instanceof \App\Models\Service) {
                        $dynamicMeta = $data['service']->meta;
                    } elseif ($routeName === 'blog-detail' && isset($data['blog']) && $data['blog'] instanceof \App\Models\Blog) {
                        // Blogs keep their SEO fields on the blogs table itself
                        $blog = $data['blog'];
                        $dynamicMeta = (object) [
                            'meta_title' => $blog->meta_title ?: $blog->title,
                            'meta_description' => $blog->meta_description ?: \Illuminate\Support\Str::limit(trim(strip_tags($blog->short_description ?? '')), 160),
                            'meta_keyword' => $blog->meta_keyword,
                            'other_meta_tags' => $blog->other_meta_tags,
                            'og_image_url' => $blog->image ? asset('storage/' . $blog->image) : null,
                        ];
                    } elseif ($routeName === 'product-category' && isset($data['category']) && $data['category'] instanceof \App\Models\Category) {
                        $dynamicMeta = $data['category']->meta;
                    }

                    $view->with('pageMeta', $dynamicMeta ?? $metadata);
                });
            }
            catch (\Exception $e) {
            // Silently fail if table doesn't exist yet during installation or migrations
            }
        }
    }
}
