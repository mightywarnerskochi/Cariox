<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\WebsiteController;

Route::get('/', [WebsiteController::class, 'home'])->name('home');
Route::get('/about', [WebsiteController::class, 'about'])->name('about');
Route::get('/services', [WebsiteController::class, 'services'])->name('services');
Route::get('/service-detail/{slug?}', [WebsiteController::class, 'serviceDetail'])->name('service-detail');
Route::get('/products', [WebsiteController::class, 'products'])->name('products');
Route::get('/product-detail/{slug?}', [WebsiteController::class, 'productDetail'])->name('product-detail');
Route::get('/product-category/{slug?}', [WebsiteController::class, 'productCategory'])->name('product-category');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact');
Route::post('/contact', [WebsiteController::class, 'storeContact'])->name('contact.submit');
Route::post('/enquiry', [WebsiteController::class, 'submitEnquiry'])->name('enquiry-submit');
Route::post('/download-brochure', [WebsiteController::class, 'downloadBrochure'])->name('brochure.download');
Route::get('/blogs', [WebsiteController::class, 'blogs'])->name('blogs');
Route::get('/blog-detail/{slug?}', [WebsiteController::class, 'blogDetail'])->name('blog-detail');
Route::get('/terms-and-conditions', [WebsiteController::class, 'termsAndConditions'])->name('terms-and-conditions');
Route::get('/privacy-policy', [WebsiteController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/thank-you', [WebsiteController::class, 'thankYou'])->name('thank-you');

Route::post('/newsletter/subscribe', [\App\Http\Controllers\Website\NewsletterSubscribeController::class, 'subscribe'])->name('newsletter.subscribe');
