<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Category;
use App\Models\PageMetadata;
use App\Models\Product;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Builds public/llms.txt (https://llmstxt.org) so AI crawlers get a clean map of the site.
 * Only the block between the markers is rewritten; anything outside it is kept as written.
 */
class LlmsTxtGenerator
{
    public const START_MARKER = '<!-- llms:generated:start -->';
    public const END_MARKER = '<!-- llms:generated:end -->';

    private const STATIC_PAGES = [
        'home' => 'Home',
        'about' => 'About Us',
        'products' => 'Products',
        'services' => 'Services',
        'blogs' => 'Blogs',
        'contact' => 'Contact Us',
    ];

    public static function path(): string
    {
        return public_path('llms.txt');
    }

    /**
     * Write llms.txt and return the number of links in the generated block.
     */
    public function generate(): int
    {
        [$block, $count] = $this->buildBlock();
        $wrapped = self::START_MARKER . "\n" . $block . self::END_MARKER;

        $existing = File::exists(self::path()) ? File::get(self::path()) : null;
        $start = $existing !== null ? strpos($existing, self::START_MARKER) : false;
        $end = $existing !== null ? strpos($existing, self::END_MARKER) : false;

        if ($start !== false && $end !== false && $end > $start) {
            $content = substr($existing, 0, $start) . $wrapped . substr($existing, $end + strlen(self::END_MARKER));
        } elseif ($existing !== null && trim($existing) !== '') {
            // Markers were removed by hand: keep the manual text and append a fresh block
            $content = rtrim($existing) . "\n\n" . $wrapped . "\n";
        } else {
            $content = $this->header() . $wrapped . "\n";
        }

        File::put(self::path(), $content);

        return $count;
    }

    private function header(): string
    {
        $setting = SiteSetting::first();
        $name = $setting->company_name ?? config('app.name');

        $summary = PageMetadata::where('page_name', 'home')->value('meta_description')
            ?: $this->clean($setting->footer_logo_description ?? '');

        $header = "# {$name}\n\n";
        if ($summary) {
            $header .= "> {$summary}\n\n";
        }

        $contact = array_filter([
            $setting->official_email ?? null ? 'Email: ' . $setting->official_email : null,
            $setting->official_phone ?? null ? 'Phone: ' . $setting->official_phone : null,
        ]);
        if ($contact) {
            $header .= implode(' | ', $contact) . "\n\n";
        }

        return $header;
    }

    /**
     * @return array{0: string, 1: int}
     */
    private function buildBlock(): array
    {
        $sections = [];

        $sections['Main Pages'] = collect(self::STATIC_PAGES)
            ->map(fn ($title, $route) => $this->link($title, route($route)))
            ->values()->all();

        $sections['Product Categories'] = Category::where('status', 1)->orderBy('position')->get(['name', 'slug', 'description'])
            ->map(fn ($c) => $this->link($c->name, route('product-category', $c->slug), $c->description))
            ->all();

        $sections['Products'] = Product::visible()->positioned()->get(['products.product_title', 'products.slug', 'products.sub_title', 'products.description'])
            ->map(fn ($p) => $this->link($p->product_title, route('product-detail', $p->slug), $p->sub_title ?: $p->description))
            ->all();

        $sections['Services'] = Service::where('status', 1)->whereNotNull('slug')->where('slug', '!=', '')->orderBy('position')->get(['name', 'slug', 'home_description', 'page_description'])
            ->map(fn ($s) => $this->link($s->name, route('service-detail', $s->slug), $s->home_description ?: $s->page_description))
            ->all();

        $sections['Blogs'] = Blog::where('status', 1)->positioned()->get(['title', 'slug', 'short_description'])
            ->map(fn ($b) => $this->link($b->title, route('blog-detail', $b->slug), $b->short_description))
            ->all();

        $sections['Optional'] = [
            $this->link('Sitemap', url('sitemap.xml')),
            $this->link('Terms & Conditions', route('terms-and-conditions')),
            $this->link('Privacy Policy', route('privacy-policy')),
        ];

        $block = '';
        $count = 0;
        foreach (array_filter($sections) as $heading => $links) {
            $block .= "## {$heading}\n\n" . implode("\n", $links) . "\n\n";
            $count += count($links);
        }

        return [$block, $count];
    }

    private function link(string $title, string $url, ?string $description = null): string
    {
        $title = str_replace(['[', ']'], ['(', ')'], $this->clean($title));
        $description = Str::limit($this->clean($description ?? ''), 160);

        return "- [{$title}]({$url})" . ($description !== '' ? ": {$description}" : '');
    }

    private function clean(string $text): string
    {
        $text = html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim(preg_replace('/\s+/u', ' ', $text));
    }
}
