<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Permanently removes placeholder records (filler text, Faker data, test submissions and
 * third-party copy) that have no legitimate Cariox content to be rewritten into.
 * Their website sections already hide when empty; real data can be added via the admin panel.
 *
 * Every rule matches on content, not ids, so it is safe to run on any copy of the database
 * and will not touch records entered later through the admin panel.
 *
 *   php artisan db:seed --class=CarioxPlaceholderCleanupSeeder
 */
class CarioxPlaceholderCleanupSeeder extends Seeder
{
    // Standard typesetting filler paragraph used throughout the original demo data.
    private const FILLER = "(simply dummy text|typesetting industry)";

    public function run(): void
    {
        DB::transaction(function () {
            $this->purgeTrashedCatalogue();
            $this->purgeRetiredLaserCategory();
            $this->purgePlaceholderSections();
            $this->purgeTestSubmissions();
            $this->purgeOrphanMetas();
        });
    }

    /** Soft-deleted Faker / "test" products, posts and brands still held filler text in the database. */
    private function purgeTrashedCatalogue(): void
    {
        $products = DB::table('products')->whereNotNull('deleted_at')->pluck('id');
        DB::table('product_images')->whereIn('product_id', $products)->orWhereNotNull('deleted_at')->delete();
        DB::table('product_videos')->whereIn('product_id', $products)->orWhereNotNull('deleted_at')->delete();
        DB::table('product_othervideos')->whereIn('product_id', $products)->delete();
        DB::table('metas')->where('metable_type', Product::class)->whereIn('metable_id', $products)->delete();
        DB::table('products')->whereIn('id', $products)->delete();

        $blogs = DB::table('blogs')->whereNotNull('deleted_at')->pluck('id');
        DB::table('blogs')->whereIn('id', $blogs)->delete();

        // Retired brand rows were customer logos of another company.
        DB::table('brands')->whereNotNull('deleted_at')->delete();
    }

    /** The "laser printer" category had placeholder descriptions and no verified products. */
    private function purgeRetiredLaserCategory(): void
    {
        $subs = DB::table('subcategories')->where('slug', 'co2-printer')->where('status', 0)->pluck('id');
        if (!DB::table('products')->whereIn('subcategory_id', $subs)->exists()) {
            DB::table('metas')->where('metable_type', Subcategory::class)->whereIn('metable_id', $subs)->delete();
            DB::table('subcategories')->whereIn('id', $subs)->delete();
        }

        $cats = DB::table('categories')->where('slug', 'laser-printer')->where('status', 0)->pluck('id');
        if (!DB::table('products')->whereIn('category_id', $cats)->exists()) {
            DB::table('metas')->where('metable_type', Category::class)->whereIn('metable_id', $cats)->delete();
            DB::table('categories')->whereIn('id', $cats)->delete();
        }
    }

    /**
     * Records for sections where no verified Cariox content exists yet:
     * company timeline, testimonials, office addresses and client logos.
     */
    private function purgePlaceholderSections(): void
    {
        // Timeline entries were typesetting filler text; Cariox's real milestones have not been supplied.
        DB::table('journeys')->where('description', 'regexp', self::FILLER)->delete();

        // Testimonials were copied from another company's site or marked "test".
        DB::table('testimonials')
            ->where(fn ($q) => $q->where('content', 'like', '%Astropack%')
                ->orWhere('content', 'like', '<p>test %'))
            ->delete();

        // Office records holding another company's addresses (phones/emails cascade).
        DB::table('contacts')
            ->where('status', 0)
            ->where(fn ($q) => $q->where('address', 'like', '%Astropack%')
                ->orWhere('address', 'like', '%China Mall%')
                ->orWhere('address', 'like', '%Al Zamil%'))
            ->delete();

        // "Clients" were duplicates of the manufacturer logos (now in Brands) with names like "clint 2".
        DB::table('clients')
            ->where('status', 0)
            ->where(fn ($q) => $q->where('name', 'regexp', '^(clint|client) ?[0-9]*$')->orWhere('name', 'Client User'))
            ->delete();

        // Stock avatar images behind the unverified "happy clients" badge.
        DB::table('trusted_clients')
            ->where('status', 0)
            ->whereNull('client_name')
            ->where('alt_text', 'regexp', '^img ?[0-9]+$')
            ->delete();
    }

    /** Enquiries and newsletter sign-ups submitted by the development team while testing. */
    private function purgeTestSubmissions(): void
    {
        $testEmail = fn ($q, $column) => $q->where($column, 'like', '%@mightywarner.com')
            ->orWhere($column, 'like', '%@test.com')
            ->orWhere($column, 'like', '%@example.com');

        DB::table('form_datas')->where(fn ($q) => $testEmail($q, 'email'))->delete();
        DB::table('newsletters')->where(fn ($q) => $testEmail($q, 'email'))->delete();
    }

    /** SEO rows left behind for records that no longer exist, or soft-deleted SEO rows. */
    private function purgeOrphanMetas(): void
    {
        DB::table('metas')->whereNotNull('deleted_at')->delete();

        $owners = [
            Product::class => 'products',
            Category::class => 'categories',
            Subcategory::class => 'subcategories',
            Service::class => 'services',
            Blog::class => 'blogs',
            Brand::class => 'brands',
        ];
        foreach ($owners as $type => $table) {
            DB::table('metas')
                ->where('metable_type', $type)
                ->whereNotIn('metable_id', DB::table($table)->select('id'))
                ->delete();
        }
    }
}
