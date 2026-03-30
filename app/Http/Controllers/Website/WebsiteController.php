<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HomeBannerContent;
use App\Models\HomeBannerMedia;
use App\Models\TrustedClient;
use App\Models\Service;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use App\Models\AboutUs;
use App\Models\ChooseUs;
use App\Models\ChooseUsItem;
use App\Models\Journey;
use App\Models\Category;
use App\Models\Contact;
use App\Models\FormData;
use Illuminate\Support\Str;
use App\Models\Testimonial;
use App\Models\Client;
use App\Models\Subcategory;
use App\Models\SectionContent;

class WebsiteController extends Controller
{
    public function home()
    {
        $banner = HomeBannerContent::with(['trustedClients' => function($q) {
            $q->where('status', 1)->orderBy('position');
        }])->first();
        $bannerMedia = HomeBannerMedia::where('status', 1)->orderBy('position')->get();
        $clientsCount = TrustedClient::count();
        $services = Service::where('status', 1)->orderBy('position')->get();
        $products = Product::with(['brand'])->where('status', 1)->positioned()->take(8)->get();
        $brands = Brand::where('status', 1)->positioned()->get();
        $clients = Client::where('status', 1)->positioned()->get();
        $blogs = Blog::where('status', 1)->positioned()->take(4)->get();
        $about = AboutUs::with('images')->first();

        $clientSection = SectionContent::where('section', 'client')->first();
        $brandSection = SectionContent::where('section', 'brand')->first();
        $aboutSection = SectionContent::where('section', 'about_us')->first();
        $serviceSection = SectionContent::where('section', 'services')->first();
        $blogSection = SectionContent::where('section', 'blog')->first();
        $productSection = SectionContent::where('section', 'products')->first();
        $testimonials = Testimonial::where('status', 1)->orderBy('position')->get();
        // Admin panel uses section key `testimonials`; legacy rows may use `testimonial`.
        $testimonialSection = SectionContent::where('section', 'testimonials')->first()
            ?? SectionContent::where('section', 'testimonial')->first();
        $categories = Category::where('status', 1)->where('display_to_home', 'Yes')->get();
        
        return view('website.home', compact(
            'banner', 'bannerMedia', 'clientsCount', 'services', 'serviceSection', 'productSection', 
            'products', 'brands', 'brandSection', 'clients', 'clientSection', 'blogs', 'blogSection', 'about', 'aboutSection', 'categories', 'testimonials', 'testimonialSection'
        ));
    }

    public function about()
    {
        $about = AboutUs::with('images')->firstOrCreate([], ['status' => 1]);
        $aboutSection = SectionContent::firstOrCreate(['section' => 'about_us']);
        $brandSection = SectionContent::firstOrCreate(['section' => 'brand']);

        $chooseUs = ChooseUs::firstOrCreate(['status' => 1], ['status' => 1]);
        // `choose_us_items` table uses `order` (not `position`)
        $chooseUsItems = ChooseUsItem::where('status', 1)->orderBy('order')->get();

        $journeys = Journey::where('status', 1)->orderBy('order')->get();
        $brands = Brand::where('status', 1)->positioned()->get();

        return view('website.about', compact(
            'about',
            'aboutSection',
            'brandSection',
            'chooseUs',
            'chooseUsItems',
            'journeys',
            'brands'
        ));
    }

    public function services()
    {
        $services = Service::where('status', 1)->orderBy('position')->get();
        $serviceSection = SectionContent::where('section', 'services')->first();
        return view('website.services', compact('services', 'serviceSection'));
    }

    public function serviceDetail($slug = null)
    {
        if ($slug) {
            $service = Service::where('slug', $slug)->firstOrFail();
        } else {
            $service = Service::firstOrFail();
        }
        return view('website.service-detail', compact('service'));
    }

    public function products(Request $request)
    {
        $query = Product::where('status', 1);

        if ($request->has('category')) {
            $catArr = (array) $request->category;
            $cats = Category::whereIn('slug', $catArr)->pluck('id');
            if ($cats->count() > 0) {
                $query->whereIn('category_id', $cats);
            }
        }

        if ($request->has('subcategory')) {
            $subArr = (array) $request->subcategory;
            $subs = Subcategory::whereIn('slug', $subArr)->pluck('id');
            if ($subs->count() > 0) {
                $query->whereIn('subcategory_id', $subs);
            }
        }

        if ($request->has('brand')) {
            $brandArr = (array) $request->brand;
            $brands_filter = Brand::whereIn('slug', $brandArr)->pluck('id');
            if ($brands_filter->count() > 0) {
                $query->whereIn('brand_id', $brands_filter);
            }
        }

        if ($request->has('product')) {
            $prodArr = (array) $request->product;
            $filterProducts = Product::whereIn('slug', $prodArr)->pluck('id');
            if ($filterProducts->count() > 0) {
                $query->whereIn('id', $filterProducts);
            }
        }

        if ($request->has('q')) {
            $query->where('product_title', 'like', '%' . $request->q . '%');
        }

        $sort = $request->get('sort', 'newest');
        if ($sort == 'az') {
            $query->orderBy('product_title', 'asc');
        } elseif ($sort == 'za') {
            $query->orderBy('product_title', 'desc');
        } else {
            $query->positioned()->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::with(['subcategories' => function($q) {
            $q->where('status', 1)->orderBy('position')->with(['products' => function($pq) {
                $pq->where('status', 1)->positioned();
            }]);
        }])->where('status', 1)->orderBy('position')->get();
        $brands = Brand::where('status', 1)->positioned()->get();

        return view('website.products', compact('products', 'categories', 'brands'));
    }

    public function productCategory($slug = null)
    {
        if (!$slug) return redirect()->route('products');
        
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)->where('status', 1)->positioned()->paginate(12)->withQueryString();
        $categories = Category::with(['subcategories' => function($q) {
            $q->where('status', 1)->orderBy('position')->with(['products' => function($pq) {
                $pq->where('status', 1)->positioned();
            }]);
        }])->where('status', 1)->orderBy('position')->get();

        return view('website.product-category', compact('products', 'category', 'categories'));
    }

    public function productDetail($slug = null)
    {
        if (!$slug) return redirect()->route('products');
        
        $product = Product::with(['images', 'brand', 'otherVideos', 'videos'])->where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->positioned()->take(4)->get();
        $majorProducts = Product::where('status', 1)->positioned()->take(6)->get();
        return view('website.product-detail', compact('product', 'relatedProducts', 'majorProducts'));
    }

    public function contact()
    {
        $contacts = Contact::with(['phones', 'emails'])->where('status', 1)->orderBy('order')->get();
        return view('website.contact', compact('contacts'));
    }

    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        FormData::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company' => $validated['company'] ?? null,
            'product_name' => null,
            'message' => $validated['message'],
            'page_source' => 'contact',
            'page_url' => $request->fullUrl(),
        ]);

        return redirect()->route('thank-you');
    }

    public function submitEnquiry(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:50',
            'company' => 'nullable|string|max:255',
            'message' => 'required_unless:form_type,brochure|nullable|string',
            'product_id' => 'nullable|exists:products,id',
            'service_id' => 'nullable|exists:services,id',
            'form_type' => 'required|string',
        ]);

        $productName = $request->product_name;
        if (!$productName) {
            if ($request->product_id) {
                $product = \App\Models\Product::find($request->product_id);
                if ($product) {
                    $productName = $product->product_title;
                }
            } elseif ($request->service_id) {
                $service = \App\Models\Service::find($request->service_id);
                if ($service) {
                    $productName = 'Service: ' . $service->name;
                }
            }
        }

        FormData::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone_number'],
            'company' => $validated['company'] ?? null,
            'product_name' => $productName,
            'message' => $validated['message'] ?? ($request->form_type == 'brochure' ? 'Brochure download request' : null),
            'page_source' => $validated['form_type'],
            'page_url' => $request->header('referer') ?: $request->fullUrl(),
        ]);

        return redirect()->route('thank-you');
    }

    public function downloadBrochure(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:50',
            'product_name' => 'required|string',
            'brochure' => 'required|string'
        ]);

        FormData::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone_number'],
            'product_name' => $validated['product_name'],
            'message' => 'Brochure download request',
            'page_source' => 'brochure_download',
            'page_url' => url()->previous(),
        ]);

        if (Storage::disk('public')->exists($validated['brochure'])) {
            return response()->json([
                'success' => true,
                'file_url' => asset('storage/' . $validated['brochure'])
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Brochure file not found.'
        ], 404);
    }

    public function blogs()
    {
        $blogs = Blog::where('status', 1)->positioned()->paginate(16);
        return view('website.blogs', compact('blogs'));
    }

    public function blogDetail($slug = null)
    {
        if (!$slug) return redirect()->route('blogs');
        
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $recentBlogs = Blog::where('status', 1)->where('id', '!=', $blog->id)->positioned()->take(3)->get();
        return view('website.blog-detail', compact('blog', 'recentBlogs'));
    }

    public function termsAndConditions()
    {
        return view('website.terms-and-conditions');
    }

    public function privacyPolicy()
    {
        return view('website.privacy-policy');
    }

    public function thankYou()
    {
        return view('website.thank-you');
    }

}
