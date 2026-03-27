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
    //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
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

                $whatsappNumber = '971545864310'; // Default
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

                    if (isset($data['product']) && $data['product'] instanceof \App\Models\Product) {
                        $dynamicMeta = $data['product']->meta;
                    } elseif (isset($data['service']) && $data['service'] instanceof \App\Models\Service) {
                        $dynamicMeta = $data['service']->meta;
                    } elseif (isset($data['blog']) && $data['blog'] instanceof \App\Models\Blog) {
                        $dynamicMeta = $data['blog']->meta;
                    } elseif (isset($data['category']) && $data['category'] instanceof \App\Models\Category) {
                        $dynamicMeta = $data['category']->meta;
                    } elseif (isset($data['subcategory']) && $data['subcategory'] instanceof \App\Models\Subcategory) {
                        $dynamicMeta = $data['subcategory']->meta;
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
