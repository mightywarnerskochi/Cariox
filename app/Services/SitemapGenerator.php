<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class SitemapGenerator
{
    /**
     * Static website pages: route name => [changefreq, priority].
     */
    private const STATIC_PAGES = [
        'home' => ['daily', '1.0'],
        'about' => ['monthly', '0.8'],
        'products' => ['weekly', '0.9'],
        'services' => ['weekly', '0.9'],
        'blogs' => ['weekly', '0.8'],
        'contact' => ['monthly', '0.7'],
        'terms-and-conditions' => ['yearly', '0.3'],
        'privacy-policy' => ['yearly', '0.3'],
    ];

    public static function path(): string
    {
        return public_path('sitemap.xml');
    }

    /**
     * Build the sitemap from the active content and write it to public/sitemap.xml.
     * Returns the number of URLs written.
     */
    public function generate(): int
    {
        $urls = $this->collectUrls();
        File::put(self::path(), $this->toXml($urls));

        return count($urls);
    }

    private function collectUrls(): array
    {
        $urls = [];

        foreach (self::STATIC_PAGES as $route => [$changefreq, $priority]) {
            $urls[] = $this->entry(route($route), null, $changefreq, $priority);
        }

        Category::where('status', 1)->orderBy('position')->get(['slug', 'updated_at'])
            ->each(function ($category) use (&$urls) {
                $urls[] = $this->entry(route('product-category', $category->slug), $category->updated_at, 'weekly', '0.8');
            });

        Product::visible()->positioned()->get(['products.slug', 'products.updated_at'])
            ->each(function ($product) use (&$urls) {
                $urls[] = $this->entry(route('product-detail', $product->slug), $product->updated_at, 'weekly', '0.7');
            });

        Service::where('status', 1)->whereNotNull('slug')->where('slug', '!=', '')->orderBy('position')->get(['slug', 'updated_at'])
            ->each(function ($service) use (&$urls) {
                $urls[] = $this->entry(route('service-detail', $service->slug), $service->updated_at, 'monthly', '0.7');
            });

        Blog::where('status', 1)->positioned()->get(['slug', 'updated_at'])
            ->each(function ($blog) use (&$urls) {
                $urls[] = $this->entry(route('blog-detail', $blog->slug), $blog->updated_at, 'monthly', '0.6');
            });

        // Guard against duplicate slugs producing repeated <loc> entries
        return collect($urls)->unique('loc')->values()->all();
    }

    private function entry(string $loc, ?Carbon $lastmod, string $changefreq, string $priority): array
    {
        return [
            'loc' => $loc,
            'lastmod' => ($lastmod ?? now())->toAtomString(),
            'changefreq' => $changefreq,
            'priority' => $priority,
        ];
    }

    private function toXml(array $urls): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . htmlspecialchars($url['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</loc>\n";
            $xml .= '    <lastmod>' . $url['lastmod'] . "</lastmod>\n";
            $xml .= '    <changefreq>' . $url['changefreq'] . "</changefreq>\n";
            $xml .= '    <priority>' . $url['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        return $xml . "</urlset>\n";
    }
}
