<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\HomeBannerContentController;
use App\Http\Controllers\Admin\HomeBannerMediaController;
use App\Http\Controllers\Admin\TrustedClientController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\ChooseUsController;
use App\Http\Controllers\Admin\JourneyController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\FormDataController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\HeaderLinkController;
use App\Http\Controllers\Admin\PageMetadataController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AdminRedirectIfAuthenticated;



Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    // Guest Admin Routes
    Route::middleware([AdminRedirectIfAuthenticated::class])->group(function () {
            Route::get('/', [AdminAuthController::class , 'showLoginForm'])->name('login');
            Route::post('/', [AdminAuthController::class , 'login']);
        }
        );

        // Authenticated Admin Routes
        Route::middleware([AdminMiddleware::class])->group(function () {
            Route::get('dashboard', [AdminController::class , 'index'])->name('dashboard');
            Route::get('profile', [AdminController::class , 'profile'])->name('profile');
            Route::post('profile', [AdminController::class , 'updateProfile'])->name('profile.update');

            // Home Menu Routes
            Route::group(['prefix' => 'home', 'as' => 'home.'], function () {
                    Route::get('banner', [HomeBannerContentController::class , 'index'])->name('banner.index');
                    Route::post('banner', [HomeBannerContentController::class , 'storeOrUpdate'])->name('banner.store');

                    // Media
                    Route::post('media/store', [HomeBannerMediaController::class , 'store'])->name('media.store');
                    Route::put('media/{id}/update', [HomeBannerMediaController::class , 'update'])->name('media.update');
                    Route::delete('media/bulk-delete', [HomeBannerMediaController::class , 'bulkDelete'])->name('media.bulkDelete');
                    Route::post('media/bulk-toggle-status', [HomeBannerMediaController::class , 'bulkToggleStatus'])->name('media.bulkToggleStatus');
                    Route::delete('media/{id}/destroy', [HomeBannerMediaController::class , 'destroy'])->name('media.destroy');
                    Route::post('media/toggle-status', [HomeBannerMediaController::class , 'toggleStatus'])->name('media.toggleStatus');
                    Route::post('media/chunk-upload', [HomeBannerMediaController::class , 'chunkUpload'])->name('media.chunkUpload');

                    // Trusted Clients
                    Route::post('client/store', [TrustedClientController::class , 'store'])->name('client.store');
                    Route::put('client/{id}/update', [TrustedClientController::class , 'update'])->name('client.update');
                    Route::delete('client/bulk-delete', [TrustedClientController::class , 'bulkDelete'])->name('client.bulkDelete');
                    Route::post('client/bulk-toggle-status', [TrustedClientController::class , 'bulkToggleStatus'])->name('client.bulkToggleStatus');
                    Route::delete('client/{id}/destroy', [TrustedClientController::class , 'destroy'])->name('client.destroy');
                    Route::post('client/toggle-status', [TrustedClientController::class , 'toggleStatus'])->name('client.toggleStatus');
                }
                );

                // Brand Routes
                Route::group(['prefix' => 'brand', 'as' => 'brand.'], function () {
                    Route::get('/', [\App\Http\Controllers\Admin\BrandController::class , 'index'])->name('index');
                    Route::post('store-section', [\App\Http\Controllers\Admin\BrandController::class , 'storeSection'])->name('storeSection');
                    Route::get('create', [\App\Http\Controllers\Admin\BrandController::class , 'create'])->name('create');
                    Route::post('store', [\App\Http\Controllers\Admin\BrandController::class , 'store'])->name('store');
                    Route::get('{id}/edit', [\App\Http\Controllers\Admin\BrandController::class , 'edit'])->name('edit');
                    Route::put('{id}/update', [\App\Http\Controllers\Admin\BrandController::class , 'update'])->name('update');
                    Route::delete('bulk-delete', [\App\Http\Controllers\Admin\BrandController::class , 'bulkDelete'])->name('bulkDelete');
                    Route::post('bulk-toggle-status', [\App\Http\Controllers\Admin\BrandController::class , 'bulkToggleStatus'])->name('bulkToggleStatus');
                    Route::delete('{id}/destroy', [\App\Http\Controllers\Admin\BrandController::class , 'destroy'])->name('destroy');
                    Route::post('toggle-status', [\App\Http\Controllers\Admin\BrandController::class , 'toggleStatus'])->name('toggleStatus');
                }
                );

                // Client Routes (General)
                Route::group(['prefix' => 'client', 'as' => 'client.'], function () {
                    Route::get('/', [\App\Http\Controllers\Admin\ClientController::class , 'index'])->name('index');
                    Route::post('store-section', [\App\Http\Controllers\Admin\ClientController::class , 'storeSection'])->name('storeSection');
                    Route::get('create', [\App\Http\Controllers\Admin\ClientController::class , 'create'])->name('create');
                    Route::post('store', [\App\Http\Controllers\Admin\ClientController::class , 'store'])->name('store');
                    Route::get('{id}/edit', [\App\Http\Controllers\Admin\ClientController::class , 'edit'])->name('edit');
                    Route::put('{id}/update', [\App\Http\Controllers\Admin\ClientController::class , 'update'])->name('update');
                    Route::delete('bulk-delete', [\App\Http\Controllers\Admin\ClientController::class , 'bulkDelete'])->name('bulkDelete');
                    Route::post('bulk-toggle-status', [\App\Http\Controllers\Admin\ClientController::class , 'bulkToggleStatus'])->name('bulkToggleStatus');
                    Route::delete('{id}/destroy', [\App\Http\Controllers\Admin\ClientController::class , 'destroy'])->name('destroy');
                    Route::post('toggle-status', [\App\Http\Controllers\Admin\ClientController::class , 'toggleStatus'])->name('toggleStatus');
                }
                );

                // Testimonial Routes
                Route::group(['prefix' => 'testimonial', 'as' => 'testimonial.'], function () {
                    Route::get('/', [\App\Http\Controllers\Admin\TestimonialController::class , 'index'])->name('index');
                    Route::post('store-section', [\App\Http\Controllers\Admin\TestimonialController::class , 'storeSection'])->name('storeSection');
                    Route::get('create', [\App\Http\Controllers\Admin\TestimonialController::class , 'create'])->name('create');
                    Route::post('store', [\App\Http\Controllers\Admin\TestimonialController::class , 'store'])->name('store');
                    Route::get('{id}/edit', [\App\Http\Controllers\Admin\TestimonialController::class , 'edit'])->name('edit');
                    Route::put('{id}/update', [\App\Http\Controllers\Admin\TestimonialController::class , 'update'])->name('update');
                    Route::delete('bulk-delete', [\App\Http\Controllers\Admin\TestimonialController::class , 'bulkDelete'])->name('bulkDelete');
                    Route::post('bulk-toggle-status', [\App\Http\Controllers\Admin\TestimonialController::class , 'bulkToggleStatus'])->name('bulkToggleStatus');
                    Route::delete('{id}/destroy', [\App\Http\Controllers\Admin\TestimonialController::class , 'destroy'])->name('destroy');
                    Route::post('toggle-status', [\App\Http\Controllers\Admin\TestimonialController::class , 'toggleStatus'])->name('toggleStatus');
                }
                );

                // Service Routes
                Route::group(['prefix' => 'service', 'as' => 'service.'], function () {
                    Route::get('/', [\App\Http\Controllers\Admin\ServiceController::class , 'index'])->name('index');
                    Route::post('store-section', [\App\Http\Controllers\Admin\ServiceController::class , 'storeSection'])->name('storeSection');
                    Route::get('create', [\App\Http\Controllers\Admin\ServiceController::class , 'create'])->name('create');
                    Route::post('store', [\App\Http\Controllers\Admin\ServiceController::class , 'store'])->name('store');
                    Route::get('{id}/edit', [\App\Http\Controllers\Admin\ServiceController::class , 'edit'])->name('edit');
                    Route::put('{id}/update', [\App\Http\Controllers\Admin\ServiceController::class , 'update'])->name('update');
                    Route::delete('bulk-delete', [\App\Http\Controllers\Admin\ServiceController::class , 'bulkDelete'])->name('bulkDelete');
                    Route::post('bulk-toggle-status', [\App\Http\Controllers\Admin\ServiceController::class , 'bulkToggleStatus'])->name('bulkToggleStatus');
                    Route::delete('{id}/destroy', [\App\Http\Controllers\Admin\ServiceController::class , 'destroy'])->name('destroy');
                    Route::post('toggle-status', [\App\Http\Controllers\Admin\ServiceController::class , 'toggleStatus'])->name('toggleStatus');
                }
                );

                // Category Routes
                Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
                    Route::get('/', [\App\Http\Controllers\Admin\CategoryController::class , 'index'])->name('index');
                    Route::post('store-section', [\App\Http\Controllers\Admin\CategoryController::class , 'storeSection'])->name('storeSection');
                    Route::get('create', [\App\Http\Controllers\Admin\CategoryController::class , 'create'])->name('create');
                    Route::post('store', [\App\Http\Controllers\Admin\CategoryController::class , 'store'])->name('store');
                    Route::get('{id}/edit', [\App\Http\Controllers\Admin\CategoryController::class , 'edit'])->name('edit');
                    Route::put('{id}/update', [\App\Http\Controllers\Admin\CategoryController::class , 'update'])->name('update');
                    Route::delete('bulk-delete', [\App\Http\Controllers\Admin\CategoryController::class , 'bulkDelete'])->name('bulkDelete');
                    Route::post('bulk-toggle-status', [\App\Http\Controllers\Admin\CategoryController::class , 'bulkToggleStatus'])->name('bulkToggleStatus');
                    Route::delete('{id}/destroy', [\App\Http\Controllers\Admin\CategoryController::class , 'destroy'])->name('destroy');
                    Route::post('toggle-status', [\App\Http\Controllers\Admin\CategoryController::class , 'toggleStatus'])->name('toggleStatus');
                }
                );

                // Subcategory Routes
                Route::group(['prefix' => 'subcategory', 'as' => 'subcategory.'], function () {
                    Route::get('/', [\App\Http\Controllers\Admin\SubcategoryController::class , 'index'])->name('index');
                    Route::get('create', [\App\Http\Controllers\Admin\SubcategoryController::class , 'create'])->name('create');
                    Route::post('store', [\App\Http\Controllers\Admin\SubcategoryController::class , 'store'])->name('store');
                    Route::get('{id}/edit', [\App\Http\Controllers\Admin\SubcategoryController::class , 'edit'])->name('edit');
                    Route::put('{id}/update', [\App\Http\Controllers\Admin\SubcategoryController::class , 'update'])->name('update');
                    Route::delete('bulk-delete', [\App\Http\Controllers\Admin\SubcategoryController::class , 'bulkDelete'])->name('bulkDelete');
                    Route::post('bulk-toggle-status', [\App\Http\Controllers\Admin\SubcategoryController::class , 'bulkToggleStatus'])->name('bulkToggleStatus');
                    Route::delete('{id}/destroy', [\App\Http\Controllers\Admin\SubcategoryController::class , 'destroy'])->name('destroy');
                    Route::post('toggle-status', [\App\Http\Controllers\Admin\SubcategoryController::class , 'toggleStatus'])->name('toggleStatus');
                }
                );

                // Product Routes
                Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
                    Route::get('/', [\App\Http\Controllers\Admin\ProductController::class , 'index'])->name('index');
                    Route::get('create', [\App\Http\Controllers\Admin\ProductController::class , 'create'])->name('create');
                    Route::post('store', [\App\Http\Controllers\Admin\ProductController::class , 'store'])->name('store');
                    Route::get('{id}/edit', [\App\Http\Controllers\Admin\ProductController::class , 'edit'])->name('edit');
                    Route::put('{id}/update', [\App\Http\Controllers\Admin\ProductController::class , 'update'])->name('update');
                    Route::delete('bulk-delete', [\App\Http\Controllers\Admin\ProductController::class , 'bulkDelete'])->name('bulkDelete');
                    Route::post('bulk-toggle-status', [\App\Http\Controllers\Admin\ProductController::class , 'bulkToggleStatus'])->name('bulkToggleStatus');
                    Route::delete('{id}/destroy', [\App\Http\Controllers\Admin\ProductController::class , 'destroy'])->name('destroy');
                    Route::post('toggle-status', [\App\Http\Controllers\Admin\ProductController::class , 'toggleStatus'])->name('toggleStatus');
                }
                );

                // Contact Routes
                Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
                    Route::get('/', [\App\Http\Controllers\Admin\ContactController::class , 'index'])->name('index');
                    Route::get('create', [\App\Http\Controllers\Admin\ContactController::class , 'create'])->name('create');
                    Route::post('store', [\App\Http\Controllers\Admin\ContactController::class , 'store'])->name('store');
                    Route::get('{id}/edit', [\App\Http\Controllers\Admin\ContactController::class , 'edit'])->name('edit');
                    Route::put('{id}/update', [\App\Http\Controllers\Admin\ContactController::class , 'update'])->name('update');
                    Route::delete('bulk-delete', [\App\Http\Controllers\Admin\ContactController::class , 'bulkDelete'])->name('bulkDelete');
                    Route::post('bulk-toggle-status', [\App\Http\Controllers\Admin\ContactController::class , 'bulkToggleStatus'])->name('bulkToggleStatus');
                    Route::delete('{id}/destroy', [\App\Http\Controllers\Admin\ContactController::class , 'destroy'])->name('destroy');
                    Route::post('{id}/toggle-status', [\App\Http\Controllers\Admin\ContactController::class , 'toggleStatus'])->name('toggleStatus');
                }
                );

                // Blog Routes
                Route::group(['prefix' => 'blog', 'as' => 'blog.'], function () {
                    Route::get('/', [\App\Http\Controllers\Admin\BlogController::class , 'index'])->name('index');
                    Route::post('store-section', [\App\Http\Controllers\Admin\BlogController::class , 'storeSection'])->name('storeSection');
                    Route::get('create', [\App\Http\Controllers\Admin\BlogController::class , 'create'])->name('create');
                    Route::post('store', [\App\Http\Controllers\Admin\BlogController::class , 'store'])->name('store');
                    Route::get('{id}/edit', [\App\Http\Controllers\Admin\BlogController::class , 'edit'])->name('edit');
                    Route::put('{id}/update', [\App\Http\Controllers\Admin\BlogController::class , 'update'])->name('update');
                    Route::delete('bulk-delete', [\App\Http\Controllers\Admin\BlogController::class , 'bulkDelete'])->name('bulkDelete');
                    Route::post('bulk-toggle-status', [\App\Http\Controllers\Admin\BlogController::class , 'bulkToggleStatus'])->name('bulkToggleStatus');
                    Route::delete('{id}/destroy', [\App\Http\Controllers\Admin\BlogController::class , 'destroy'])->name('destroy');
                    Route::post('{id}/toggle-status', [\App\Http\Controllers\Admin\BlogController::class , 'toggleStatus'])->name('toggleStatus');
                }
                );

                // FormData Routes
                Route::group(['prefix' => 'form-data', 'as' => 'form_data.'], function () {
                    Route::get('/', [FormDataController::class , 'index'])->name('index');
                    Route::get('{id}/view', [FormDataController::class , 'show'])->name('view');
                    Route::get('export', [FormDataController::class , 'export'])->name('export');
                    Route::delete('{id}/destroy', [FormDataController::class , 'destroy'])->name('destroy');
                    Route::post('bulk-delete', [FormDataController::class , 'bulkDelete'])->name('bulkDelete');
                }
                );

                // Newsletter Routes
                Route::group(['prefix' => 'newsletter', 'as' => 'newsletter.'], function () {
                    Route::get('/', [NewsletterController::class , 'index'])->name('index');
                    Route::get('export', [NewsletterController::class , 'export'])->name('export');
                    Route::delete('{id}/destroy', [NewsletterController::class , 'destroy'])->name('destroy');
                    Route::post('bulk-delete', [NewsletterController::class , 'bulkDelete'])->name('bulkDelete');
                }
                );

                // Site Information Routes
                Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
                    Route::get('site-information', [SiteSettingController::class , 'index'])->name('info');
                    Route::put('site-information', [SiteSettingController::class , 'update'])->name('info.update');
                    Route::post('site-information/remove-image', [SiteSettingController::class , 'removeImage'])->name('info.remove_image');

                    // Header Links
                    Route::group(['prefix' => 'header-links', 'as' => 'header_links.'], function () {
                            Route::get('/', [HeaderLinkController::class , 'index'])->name('index');
                            Route::get('create', [HeaderLinkController::class , 'create'])->name('create');
                            Route::post('store', [HeaderLinkController::class , 'store'])->name('store');
                            Route::get('{id}/edit', [HeaderLinkController::class , 'edit'])->name('edit');
                            Route::post('{id}/update', [HeaderLinkController::class , 'update'])->name('update');
                            Route::delete('{id}/destroy', [HeaderLinkController::class , 'destroy'])->name('destroy');
                            Route::post('toggle-status', [HeaderLinkController::class , 'toggleStatus'])->name('toggleStatus');
                        }
                        );
                    }
                    );

                    // Page Metadata Routes
                    Route::group(['prefix' => 'metadata', 'as' => 'metadata.'], function () {
                    Route::get('/', [PageMetadataController::class , 'index'])->name('index');
                    Route::get('{page_name}/edit', [PageMetadataController::class , 'edit'])->name('edit');
                    Route::post('{page_name}/update', [PageMetadataController::class , 'update'])->name('update');
                }
                );

                // About Us Routes
                Route::group(['prefix' => 'about', 'as' => 'about.'], function () {
                    Route::get('/', [\App\Http\Controllers\Admin\AboutUsController::class , 'index'])->name('index');
                    Route::post('store-section', [\App\Http\Controllers\Admin\AboutUsController::class , 'storeSection'])->name('storeSection');
                    Route::put('update', [\App\Http\Controllers\Admin\AboutUsController::class , 'update'])->name('update');
                    Route::delete('image/{id}', [\App\Http\Controllers\Admin\AboutUsController::class , 'deleteImage'])->name('deleteImage');
                }
                );

                // Choose Us Routes
                Route::group(['prefix' => 'choose-us', 'as' => 'choose_us.'], function () {
                    Route::get('/', [\App\Http\Controllers\Admin\ChooseUsController::class , 'index'])->name('index');
                    Route::put('update-main', [\App\Http\Controllers\Admin\ChooseUsController::class , 'updateMain'])->name('updateMain');
                    Route::post('item/store', [\App\Http\Controllers\Admin\ChooseUsController::class , 'storeItem'])->name('storeItem');
                    Route::put('item/{id}/update', [\App\Http\Controllers\Admin\ChooseUsController::class , 'updateItem'])->name('updateItem');
                    Route::delete('item/{id}/destroy', [\App\Http\Controllers\Admin\ChooseUsController::class , 'destroyItem'])->name('destroyItem');
                    Route::post('item/{id}/toggle-status', [\App\Http\Controllers\Admin\ChooseUsController::class , 'toggleItemStatus'])->name('toggleStatus');
                }
                );

                // Journey Routes
                Route::group(['prefix' => 'journey', 'as' => 'journey.'], function () {
                    Route::get('/', [\App\Http\Controllers\Admin\JourneyController::class , 'index'])->name('index');
                    Route::get('create', [\App\Http\Controllers\Admin\JourneyController::class , 'create'])->name('create');
                    Route::post('store', [\App\Http\Controllers\Admin\JourneyController::class , 'store'])->name('store');
                    Route::get('{id}/edit', [\App\Http\Controllers\Admin\JourneyController::class , 'edit'])->name('edit');
                    Route::put('{id}/update', [\App\Http\Controllers\Admin\JourneyController::class , 'update'])->name('update');
                    Route::delete('bulk-delete', [\App\Http\Controllers\Admin\JourneyController::class , 'bulkDelete'])->name('bulkDelete');
                    Route::post('bulk-toggle-status', [\App\Http\Controllers\Admin\JourneyController::class , 'bulkToggleStatus'])->name('bulkToggleStatus');
                    Route::delete('{id}/destroy', [\App\Http\Controllers\Admin\JourneyController::class , 'destroy'])->name('destroy');
                    Route::post('{id}/toggle-status', [\App\Http\Controllers\Admin\JourneyController::class , 'toggleStatus'])->name('toggleStatus');
                }
                );

                Route::post('logout', [AdminAuthController::class , 'logout'])->name('logout');
            }
            );
        });
