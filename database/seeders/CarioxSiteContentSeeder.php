<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\ChooseUs;
use App\Models\ChooseUsItem;
use App\Models\Client;
use App\Models\Contact;
use App\Models\HeaderLink;
use App\Models\HomeBannerContent;
use App\Models\Journey;
use App\Models\Meta;
use App\Models\PageMetadata;
use App\Models\SectionContent;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\TrustedClient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

/**
 * Replaces placeholder / third-party copy in the CMS with original Cariox content.
 *
 * Safe to re-run: every write is an update-or-create keyed on an existing id, section or slug.
 *
 *   php artisan db:seed --class=CarioxSiteContentSeeder
 */
class CarioxSiteContentSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $this->homeBanner();
            $this->sectionContents();
            $this->aboutPage();
            $this->services();
            $this->brands();
            $this->unverifiedRecords();
            $this->siteSettings();
            $this->pageMetadata();
            $this->blogs();
        });
    }

    private function homeBanner(): void
    {
        $banner = HomeBannerContent::first() ?? new HomeBannerContent();
        $banner->fill([
            'small_title' => 'Welcome to Cariox',
            'main_title' => 'Coding, Inspection & Packaging Equipment',
            'description' => '<p>Cariox supplies industrial inkjet and thermal transfer printers, food inspection systems and packing machinery, and supports every installation with commissioning, operator training and planned maintenance.</p>',
            'button_text' => 'Explore Products',
            'button_link' => '/products',
            // No verified client count or review rating exists for Cariox, so these badges stay hidden.
            'trusted_clients_count' => null,
            'trusted_clients_label' => null,
            'rating_label' => null,
            'google_rating' => null,
            'review_label' => null,
            'status' => 1,
        ])->save();

        $header = HeaderLink::orderBy('order')->first() ?? new HeaderLink(['order' => 1]);
        $header->forceFill(['title' => 'Request a Quote', 'link' => '/contact', 'status' => 1])->save();
    }

    private function sectionContents(): void
    {
        $sections = [
            'about_us' => [
                'small_title' => 'About Cariox',
                'main_title' => 'Equipment that keeps your production line moving',
                'description' => '<p>Cariox works with manufacturers who need every pack to leave the line correctly coded, safely inspected and securely sealed. We bring together product coding, food inspection and packaging equipment from established manufacturers, so a single partner can look after the end of your line.</p>'
                    . '<p>Our team starts with your product, packaging material and line speed, then recommends equipment that suits the application rather than a one-size-fits-all model. After delivery we stay involved through installation, training and maintenance.</p>',
                'button_label' => 'More About Us',
                'link' => '/about',
            ],
            'services' => [
                'small_title' => 'Our Services',
                'main_title' => 'Support from first enquiry to long-term upkeep',
                'description' => '<p>Buying the right machine is only the start. Cariox helps you specify equipment, installs and commissions it on your line, trains your operators and keeps it performing with scheduled maintenance.</p>',
                'button_label' => 'View All Services',
                'link' => '/services',
            ],
            'products' => [
                'small_title' => 'Our Products',
                'main_title' => 'Featured Equipment',
                'description' => '<p>A selection of the coding, inspection and packaging machines we supply, from continuous inkjet coders and thermal transfer overprinters to metal detectors, vacuum packers and flow wrappers.</p>',
                'button_label' => null,
                'link' => null,
            ],
            'brand' => [
                'small_title' => 'Our Brands',
                'main_title' => 'Brands we supply',
                'description' => '<p>We work with specialist manufacturers of coding, inspection and packaging technology.</p>',
                'button_label' => null,
                'link' => null,
            ],
            'testimonials' => [
                'small_title' => 'Testimonials',
                'main_title' => 'What our customers say',
                'description' => null,
                'button_label' => null,
                'link' => null,
            ],
            'blog' => [
                'small_title' => 'Insights',
                'main_title' => 'Latest from Cariox',
                'description' => '<p>Practical guides on product coding, food safety inspection and packaging technology to help you plan your next line upgrade.</p>',
                'button_label' => null,
                'link' => null,
            ],
        ];

        foreach ($sections as $section => $values) {
            SectionContent::updateOrCreate(['section' => $section], $values);
        }
    }

    private function aboutPage(): void
    {
        $about = AboutUs::first() ?? new AboutUs();
        $about->fill([
            'detailed_description' => '<p>Cariox Technologies supplies the equipment that sits at the end of a production line: the printers that put dates, batch numbers and barcodes on every pack, the inspection systems that catch contaminants and underweight products, and the machines that seal, wrap and pack finished goods.</p>'
                . '<p>Our range covers continuous inkjet and large character printers, thermal transfer overprinters, metal detectors, X-ray inspection systems and checkweighers, together with vacuum packaging, tray sealing, flow wrapping and vertical form-fill-seal machines. Because coding, inspection and packaging are handled by one partner, the equipment on your line is chosen to work together.</p>'
                . '<p>Every project starts with your application. We look at the product, the packaging material, the line speed and the space available before recommending a machine, and we are open about what a model can and cannot do.</p>'
                . '<p>Once equipment is on site, our support continues with installation, commissioning, operator training and annual maintenance contracts, so your line keeps running and your team knows how to get the best from every machine.</p>',
            'experience_caption' => 'Years of experience',
            // Leave empty until Cariox's own figure is confirmed; the badge is hidden while empty.
            'years_of_experience' => null,
            'vision' => '<p>To be the partner manufacturers rely on for dependable coding, inspection and packaging, helping every product reach the shelf correctly marked, safe and well presented.</p>',
            'mission' => '<p>To match each customer with equipment that suits their product and process, install it properly, train the people who run it and keep it performing through responsive after-sales support.</p>',
            'status' => 1,
        ])->save();

        $choose = ChooseUs::first() ?? new ChooseUs();
        $choose->fill([
            'title' => 'Why manufacturers choose Cariox',
            'description' => '<p>We focus on practical results: the right machine for the job, a smooth start-up and support that is there when your line needs it.</p>',
            'image_alt_text' => 'Packaging line engineer reviewing equipment',
            'status' => 1,
        ])->save();

        $items = [
            'Application-Led Advice',
            'Established Equipment Brands',
            'Installation & Commissioning',
            'Operator Training',
            'Planned Maintenance',
            'Responsive After-Sales Support',
        ];
        $existing = ChooseUsItem::orderBy('order')->get()->values();
        foreach ($items as $i => $text) {
            $item = $existing[$i] ?? new ChooseUsItem(['choose_id' => $choose->id, 'order' => $i + 1]);
            $item->fill(['text' => $text, 'order' => $i + 1, 'status' => 1])->save();
        }
    }

    private function services(): void
    {
        $services = [
            'supply' => [
                'name' => 'Supply',
                'home_description' => '<p>Coding, inspection and packaging equipment selected to suit your product, packaging and line speed.</p>',
                'page_description' => '<p>We supply industrial printers, food inspection systems and packaging machines from specialist manufacturers, matched to the needs of each production line.</p>',
                'main_description' => '<h3>Equipment chosen around your application</h3>'
                    . '<p>Choosing a coder, inspection system or packaging machine starts with understanding what it has to do. Before we recommend a model, we look at your product, the substrate you print on or pack in, the speed of the line and the space available.</p>'
                    . '<p>That review lets us suggest equipment that fits: a continuous inkjet printer for coding moving products on a conveyor, a thermal transfer overprinter for crisp codes on flexible film, a metal detector or X-ray system for contaminant control, or a vacuum, tray sealing or flow wrapping machine for the pack itself.</p>'
                    . '<h3>What our supply service includes</h3>'
                    . '<ul><li>Review of your product, packaging and production requirements</li><li>Recommendation of suitable models and configuration options</li><li>Clear quotation covering equipment and any recommended accessories</li><li>Coordination of delivery to your site</li></ul>'
                    . '<p>Speak to our team about your next project and we will help you shortlist the right equipment.</p>',
                'meta' => [
                    'meta_title' => 'Industrial Coding & Packaging Equipment Supply | Cariox',
                    'meta_description' => 'Cariox supplies inkjet and thermal transfer printers, food inspection systems and packaging machines matched to your product, packaging and line speed.',
                    'meta_keyword' => 'packaging equipment supplier, coding equipment supply, food inspection equipment, industrial printers',
                ],
            ],
            'installation' => [
                'name' => 'Installation',
                'home_description' => '<p>On-site installation, commissioning and operator training for a smooth start-up.</p>',
                'page_description' => '<p>Our engineers install and commission equipment on your line, set it up to the manufacturer\'s guidelines and train your operators to run it confidently.</p>',
                'main_description' => '<h3>A planned start-up on your line</h3>'
                    . '<p>New equipment should fit into production with as little disruption as possible. We plan each installation around your schedule, confirm the mounting position, utilities and integration points in advance, and then set the machine up in line with the manufacturer\'s guidelines.</p>'
                    . '<h3>Commissioning and handover</h3>'
                    . '<p>Once the machine is in place we run it with your actual products and packaging, adjust the settings and confirm that codes, inspection results or seals meet your requirements before handing over.</p>'
                    . '<h3>Operator training</h3>'
                    . '<ul><li>Daily start-up and shut-down routines</li><li>Creating and changing messages, recipes or product settings</li><li>Routine cleaning and basic preventive care</li><li>Recognising alarms and knowing when to call for support</li></ul>'
                    . '<p>After start-up we follow up to make sure the equipment is performing as expected and your team is comfortable using it.</p>',
                'meta' => [
                    'meta_title' => 'Equipment Installation, Commissioning & Training | Cariox',
                    'meta_description' => 'Professional installation, commissioning and operator training for coding, inspection and packaging equipment, planned around your production schedule.',
                    'meta_keyword' => 'equipment installation, machine commissioning, operator training, packaging line installation',
                ],
            ],
            'annual-maintenance' => [
                'name' => 'Annual Maintenance',
                'home_description' => '<p>Scheduled servicing under an annual contract to cut unplanned downtime.</p>',
                'page_description' => '<p>An annual maintenance contract (AMC) keeps your equipment serviced on a regular schedule, with priority support when something needs attention.</p>',
                'main_description' => '<h3>Keep your line running</h3>'
                    . '<p>Coding, inspection and packaging machines work hard, often across several shifts a day. Regular servicing is the most effective way to avoid unexpected stoppages, keep print quality and detection performance consistent, and protect your investment.</p>'
                    . '<h3>What an annual maintenance contract covers</h3>'
                    . '<ul><li>Scheduled preventive maintenance visits</li><li>Inspection and replacement of wear parts as required</li><li>Checks on settings, performance and safety functions</li><li>Priority response when a breakdown occurs</li><li>Advice on operator care between visits</li></ul>'
                    . '<p>Contract terms are agreed per site and per machine, so cover can be tailored to how critical each piece of equipment is to your production. Contact us to discuss a maintenance plan for your line.</p>',
                'meta' => [
                    'meta_title' => 'Annual Maintenance Contracts (AMC) for Packaging Equipment | Cariox',
                    'meta_description' => 'Planned preventive maintenance and priority support for industrial printers, inspection systems and packaging machines to reduce downtime.',
                    'meta_keyword' => 'annual maintenance contract, AMC, preventive maintenance, packaging machine service',
                ],
            ],
        ];

        foreach ($services as $slug => $data) {
            $meta = $data['meta'];
            unset($data['meta']);
            $service = Service::where('slug', $slug)->first();
            if (!$service) {
                continue;
            }
            $service->fill($data + [
                'background_image_alt_text' => $data['name'] . ' service',
                'main_image_alt_text' => $data['name'] . ' service',
                'base_image1_alt_text' => $data['name'] . ' service',
                'base_image2_alt_text' => $data['name'] . ' service',
            ])->save();
            Meta::updateOrCreate(
                ['metable_type' => Service::class, 'metable_id' => $service->id],
                $meta + ['og_title' => $meta['meta_title'], 'og_description' => $meta['meta_description'], 'canonical_url' => null]
            );
        }
    }

    /**
     * The "brands" table previously held customer logos; product brands must be equipment manufacturers.
     * Manufacturer logos already uploaded to the project (under clients/) are reused.
     */
    private function brands(): void
    {
        $brands = [
            ['name' => 'EBS', 'slug' => 'ebs', 'source' => 'clients/uFjS5FYzenEna69kNRiqOXjqjDSEuYYdqes1s2r6.png'],
            ['name' => 'Savema', 'slug' => 'savema', 'source' => 'clients/tMwn4RzFlkQK94LgY959FMSVexZX8yDXJqVQVfM8.png'],
            ['name' => 'Thermo Scientific', 'slug' => 'thermo-scientific', 'source' => 'clients/ZzeO3CSwJLJCu93kgtJvLiNEWCeU8m2ViH3NCPnd.png'],
            ['name' => 'Henkelman', 'slug' => 'henkelman', 'source' => 'clients/aQdwLmFOLZ7IyxdOpj3buvWU8cQP7yfOzUJaOmYM.png'],
            ['name' => 'iPac', 'slug' => 'ipac', 'source' => 'clients/Zp9MlEakzGwauXPAGciUn5lxNqByoDR3lfrZLtsC.png'],
        ];

        $disk = Storage::disk('public');
        $hasSlug = Schema::hasColumn('brands', 'slug');
        $existing = Brand::withTrashed()->orderBy('id')->get()->values();
        $kept = [];

        foreach ($brands as $i => $b) {
            $target = 'brands/' . $b['slug'] . '-logo.png';
            if (!$disk->exists($target) && $disk->exists($b['source'])) {
                $disk->copy($b['source'], $target);
            }
            $brand = $existing->first(fn ($x) => strcasecmp($x->name, $b['name']) === 0) ?? $existing->get($i) ?? new Brand();
            $brand->fill([
                'name' => $b['name'],
                'image' => $target,
                'alt_text' => $b['name'] . ' logo',
                'position' => $i + 1,
                'status' => 1,
            ]);
            if ($hasSlug) {
                $brand->forceFill(['slug' => $b['slug']]);
            }
            $brand->deleted_at = null;
            $brand->save();
            $kept[] = $brand->id;
        }

        // Remaining rows were customer logos of another company: retire them.
        Brand::whereNotIn('id', $kept)->get()->each(function ($brand) {
            $brand->update(['status' => 0]);
            $brand->delete();
        });
    }

    /**
     * Records that cannot be verified as Cariox's own (third-party addresses, testimonials,
     * client logos, company history) are switched off so their sections hide on the website.
     * They are deactivated rather than destroyed so real data can be entered via the admin panel.
     */
    private function unverifiedRecords(): void
    {
        Testimonial::query()->update(['status' => 0]);
        Client::query()->update(['status' => 0]);
        TrustedClient::query()->update(['status' => 0]);
        Journey::query()->update(['status' => 0]);
        Contact::query()->update(['status' => 0]);
    }

    private function siteSettings(): void
    {
        $settings = SiteSetting::first() ?? new SiteSetting();
        $settings->fill([
            'company_name' => 'Cariox Technologies',
            // Previous phone numbers belonged to another company; enter Cariox's own via Admin > Site Settings.
            'official_phone' => null,
            'official_whatsapp' => null,
            'official_email' => null,
            'footer_logo_alt_text' => 'Cariox Technologies',
            'logo_alt_text' => 'Cariox Technologies',
            'footer_logo_description' => 'Cariox supplies industrial coding, food inspection and packaging equipment, with installation, training and maintenance support for production lines.',
            // Placeholder social URLs removed; footer icons only render when a link is set.
            'facebook_link' => null,
            'instagram_link' => null,
            'linkedin_link' => null,
            'twitter_link' => null,
            'pinterest_link' => null,
            'youtube_link' => null,
            'terms_conditions' => $this->termsHtml(),
            'privacy_policy' => $this->privacyHtml(),
        ])->save();
    }

    private function pageMetadata(): void
    {
        $pages = [
            'home' => [
                'meta_title' => 'Cariox | Industrial Coding, Inspection & Packaging Equipment',
                'meta_description' => 'Cariox supplies inkjet and thermal transfer printers, metal detectors, X-ray and checkweighing systems, and vacuum, tray sealing and flow wrapping machines.',
                'meta_keywords' => 'industrial inkjet printer, thermal transfer printer, food inspection systems, metal detector, packaging machines',
            ],
            'about' => [
                'meta_title' => 'About Cariox Technologies | Coding & Packaging Partner',
                'meta_description' => 'Learn how Cariox helps manufacturers code, inspect and pack their products with the right equipment, professional installation and ongoing support.',
                'meta_keywords' => 'about Cariox, packaging equipment company, coding and inspection solutions',
            ],
            'products' => [
                'meta_title' => 'Products | Printers, Inspection & Packing Systems | Cariox',
                'meta_description' => 'Browse Cariox industrial inkjet and laser coders, thermal transfer overprinters, food inspection systems and packing machines by category and brand.',
                'meta_keywords' => 'coding equipment, inspection systems, packing systems, vacuum packaging machine, flow wrapper',
            ],
            'services' => [
                'meta_title' => 'Services | Supply, Installation & AMC | Cariox',
                'meta_description' => 'From equipment selection and supply to installation, operator training and annual maintenance contracts, Cariox supports your line at every stage.',
                'meta_keywords' => 'equipment supply, installation and commissioning, annual maintenance contract',
            ],
            'blogs' => [
                'meta_title' => 'Blog | Coding, Inspection & Packaging Insights | Cariox',
                'meta_description' => 'Practical articles on product coding, food safety inspection and packaging technology from the Cariox team.',
                'meta_keywords' => 'packaging blog, product coding guide, food inspection guide',
            ],
            'contact' => [
                'meta_title' => 'Contact Cariox | Request a Quote or Service Visit',
                'meta_description' => 'Get in touch with Cariox to discuss coding, inspection or packaging equipment, request a quotation or arrange service support.',
                'meta_keywords' => 'contact Cariox, packaging equipment quote, service request',
            ],
            'terms-and-conditions' => [
                'meta_title' => 'Terms & Conditions | Cariox Technologies',
                'meta_description' => 'The terms that apply when you use the Cariox Technologies website and its content.',
                'meta_keywords' => null,
            ],
            'privacy-policy' => [
                'meta_title' => 'Privacy Policy | Cariox Technologies',
                'meta_description' => 'How Cariox Technologies collects, uses and protects the personal information you share through this website.',
                'meta_keywords' => null,
            ],
        ];

        foreach ($pages as $page => $meta) {
            PageMetadata::updateOrCreate(['page_name' => $page], $meta + [
                'og_title' => $meta['meta_title'],
                'og_description' => $meta['meta_description'],
                // Let the layout emit the current URL; a hard-coded localhost canonical breaks SEO on the live site.
                'canonical_url' => null,
            ]);
        }
    }

    private function blogs(): void
    {
        $posts = require __DIR__ . '/data/cariox_blogs.php';
        $keep = [];

        foreach ($posts as $post) {
            $blog = Blog::withTrashed()->find($post['id']) ?? new Blog();
            $blog->fill(collect($post)->except('id')->all() + ['author' => 'Cariox Team', 'status' => 1]);
            $blog->deleted_at = null;
            $blog->save();
            $keep[] = $blog->id;
        }

        // Remaining posts were placeholder or copied articles.
        Blog::whereNotIn('id', $keep)->get()->each(function ($blog) {
            $blog->update(['status' => 0]);
            $blog->delete();
        });
    }

    private function termsHtml(): string
    {
        return <<<'HTML'
<ul>
<li>
<h3>Acceptance of Terms</h3>
<p>By accessing or using the Cariox Technologies website you agree to these terms. If you do not agree with them, please do not use the website.</p>
</li>
<li>
<h3>Website Content</h3>
<p>The information on this website, including product descriptions and specifications, is provided for general guidance. Equipment specifications can change and some options depend on configuration, so please confirm details with our team before placing an order.</p>
</li>
<li>
<h3>Quotations and Orders</h3>
<p>Nothing on this website is a binding offer. Prices, availability, delivery and service terms are confirmed only in a written quotation or agreement issued by Cariox Technologies.</p>
</li>
<li>
<h3>Acceptable Use</h3>
<p>You must not use the website in a way that is unlawful, harmful or that could disrupt its operation, and you must not attempt to gain unauthorised access to any part of it.</p>
</li>
<li>
<h3>Intellectual Property</h3>
<p>Text, graphics and layout on this website belong to Cariox Technologies or are used with permission. Product names, brand names and logos are the property of their respective owners. You may view and print pages for your own reference but may not reproduce them for commercial purposes without written consent.</p>
</li>
<li>
<h3>Third-Party Links</h3>
<p>Links to other websites are provided for convenience. We are not responsible for the content or practices of websites we do not control.</p>
</li>
<li>
<h3>Limitation of Liability</h3>
<p>We take care to keep the website accurate and available, but we do not guarantee that it will be error-free or uninterrupted. To the extent permitted by law, Cariox Technologies is not liable for any loss arising from use of, or reliance on, the website content.</p>
</li>
<li>
<h3>Changes to These Terms</h3>
<p>We may update these terms from time to time. The version published on this page applies from the date it is posted.</p>
</li>
<li>
<h3>Contact</h3>
<p>If you have a question about these terms, please get in touch through our <a href="/contact">contact page</a>.</p>
</li>
</ul>
HTML;
    }

    private function privacyHtml(): string
    {
        return <<<'HTML'
<ul>
<li>
<h3>Introduction</h3>
<p>Cariox Technologies respects your privacy. This policy explains what personal information we collect through this website, why we collect it and how we look after it.</p>
</li>
<li>
<h3>Information We Collect</h3>
<p>When you submit an enquiry, request a brochure, contact us or subscribe to our newsletter, we collect the details you provide, such as your name, email address, phone number, company name and message. Like most websites, we may also collect basic technical data such as browser type and pages visited.</p>
</li>
<li>
<h3>How We Use Your Information</h3>
<p>We use your information to respond to your enquiry, prepare quotations, provide service support, send you information you have requested and improve our website. We do not sell your personal information.</p>
</li>
<li>
<h3>Sharing Information</h3>
<p>Where needed to answer your request, we may share relevant details with equipment manufacturers or service partners. We may also disclose information where required by law.</p>
</li>
<li>
<h3>Cookies and Analytics</h3>
<p>The website may use cookies and analytics tools to understand how visitors use it. You can control cookies through your browser settings.</p>
</li>
<li>
<h3>Data Security and Retention</h3>
<p>We take reasonable technical and organisational measures to protect your information and keep it only for as long as needed for the purposes described in this policy.</p>
</li>
<li>
<h3>Your Choices</h3>
<p>You can ask us to update or delete the personal information you have shared with us, and you can unsubscribe from our newsletter at any time.</p>
</li>
<li>
<h3>Changes to This Policy</h3>
<p>We may update this policy from time to time. The latest version will always be available on this page.</p>
</li>
<li>
<h3>Contact</h3>
<p>For any privacy question or request, please reach us through our <a href="/contact">contact page</a>.</p>
</li>
</ul>
HTML;
    }
}
