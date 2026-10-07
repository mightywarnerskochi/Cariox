<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Meta;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Loads the verified Cariox product catalogue into the existing CMS tables and retires
 * the placeholder / Faker products. Existing category and subcategory rows are reused
 * (and their public slugs kept) wherever they map onto the new structure.
 *
 * Run after CarioxSiteContentSeeder (which sets up the brands):
 *   php artisan db:seed --class=CarioxProductCatalogueSeeder
 */
class CarioxProductCatalogueSeeder extends Seeder
{
    private const CATEGORIES = [
        'inkjet' => [
            'id' => 1,
            'name' => 'Inkjet Printers',
            'slug' => 'Ink-Jet-Printers', // existing public URL, kept as-is
            'logo_source' => 'products/images/WA4QsAeSatfvstptMA84eNxM6pmgkDvQ6jrh511f.png',
            'logo' => 'categories/inkjet-printers.png',
            'description' => '<p>Industrial inkjet printers put clear, permanent codes on products and packaging without touching them. Cariox supplies the EBS range, covering portable handheld printers for large or awkward items, continuous inkjet (CIJ) printers for fast-moving conveyor lines, and large character printers for cartons, sacks and industrial goods.</p><p>Whether you need best-before dates on bottles, batch numbers on cables or barcodes on shipping cases, we will help you choose the printer, printhead and ink that suit your surface and line speed.</p>',
            'meta_title' => 'Industrial Inkjet Printers: CIJ, Handheld & Large Character | Cariox',
            'meta_description' => 'EBS continuous inkjet, handheld and large character printers for date, batch and barcode coding on bottles, cans, cartons, cables and pipes.',
            'keywords' => 'industrial inkjet printer, CIJ printer, handheld inkjet printer, large character printer, EBS printers',
        ],
        'tto' => [
            'id' => 3,
            'name' => 'Thermal Transfer Printers',
            'slug' => 'thermal-transfer-printers',
            'logo' => null, // no matching photo in the media library yet
            'description' => '<p>Thermal transfer overprinters (TTO) print high-resolution dates, batch codes, barcodes and logos straight onto flexible packaging film and labels. Cariox supplies the Savema range, with intermittent models for vertical form-fill-seal machines and thermoformers, continuous models for flow wrappers and labellers, and a traverse printer for wide, multi-lane webs.</p><p>Savema feeders complete the range, presenting pouches, bags and leaflets one at a time for coding or labelling.</p>',
            'meta_title' => 'Thermal Transfer Overprinters (TTO) | Savema | Cariox',
            'meta_description' => 'Savema intermittent, continuous and traverse thermal transfer overprinters at 300 dpi for coding flexible film and labels, plus pouch feeders.',
            'keywords' => 'thermal transfer overprinter, TTO printer, Savema printer, film coding printer',
        ],
        'inspection' => [
            'id' => 4,
            'name' => 'Food Inspection Systems',
            'slug' => 'food-inspection-systems',
            'logo' => 'categories/DKNY1Hmdh6ml7CIi5M9zR4mnvpa8fNwV7uwzKtzc.jpg',
            'description' => '<p>Food inspection systems protect consumers and brands by finding contaminated, damaged or incorrectly filled packs before they leave the factory. Cariox supplies Thermo Scientific metal detectors, X-ray inspection systems and checkweighers for food, beverage and pharmaceutical lines.</p><p>From an entry-level metal detector to multi-frequency detection, side-shoot X-ray for bottles and cans, and checkweighers for anything from single packs to 50 kg cases, we help you build the right inspection point for each stage of your process.</p>',
            'meta_title' => 'Food Inspection Systems: Metal Detectors, X-Ray & Checkweighers | Cariox',
            'meta_description' => 'Thermo Scientific metal detectors, food X-ray inspection systems and checkweighers to detect contaminants and verify pack weights on production lines.',
            'keywords' => 'food inspection systems, metal detector, x-ray inspection, checkweigher, Thermo Scientific',
        ],
        'packing' => [
            'id' => null,
            'name' => 'Packing Systems',
            'slug' => 'packing-systems',
            'logo_source' => 'categories/a4mkbdfCBM31B7gR4jtJfVwl83tBUjH5s0DrmQUc.png',
            'logo' => 'categories/packing-systems.png',
            'description' => '<p>Cariox packing systems cover the main ways products are packed and protected: vacuum packaging, tray sealing and skin packing, flow wrapping, vertical form-fill-seal bagging, pre-made pouch filling and carton sealing.</p><p>The range spans Henkelman tabletop and double-chamber vacuum packers, BMB tray sealers and belt vacuum machines, the Delfin flow wrapper, iPac weighing, powder and pouch packing systems, and Packway carton tapers, so you can equip anything from a restaurant kitchen to a high-output production line.</p>',
            'meta_title' => 'Packing Systems: Vacuum, Tray Sealing, Flow Wrap & VFFS | Cariox',
            'meta_description' => 'Vacuum packaging machines, tray sealers, flow wrappers, VFFS baggers, pouch fillers and carton sealers from Henkelman, BMB, Delfin, iPac and Packway.',
            'keywords' => 'packing systems, vacuum packaging machine, tray sealing machine, flow wrapping machine, VFFS machine',
        ],
    ];

    private const SUBCATEGORIES = [
        'handheld' => ['id' => 4, 'category' => 'inkjet', 'name' => 'Handheld Inkjet Printers', 'slug' => 'handheld-inkjet-printers', 'description' => 'Cordless, battery-powered inkjet printers for marking large or hard-to-move items by hand.'],
        'cij' => ['id' => 1, 'category' => 'inkjet', 'name' => 'Continuous Inkjet (CIJ) Printers', 'slug' => 'small-character-printers', 'description' => 'Non-contact small character printers for high-speed coding on conveyor lines.'],
        'large' => ['id' => 2, 'category' => 'inkjet', 'name' => 'Large Character Printers', 'slug' => 'large-character-printer', 'description' => 'Drop-on-demand and valvejet printers for bold codes, text and barcodes on cartons and industrial products.'],
        'tto-intermittent' => ['id' => 5, 'category' => 'tto', 'name' => 'Intermittent Thermal Transfer Printers', 'slug' => 'intermittent-thermal-transfer-printers', 'description' => 'Thermal transfer overprinters for packaging machines that index the film.'],
        'tto-continuous' => ['id' => 6, 'category' => 'tto', 'name' => 'Continuous Thermal Transfer Printers', 'slug' => 'continuous-thermal-transfer-printers', 'description' => 'Thermal transfer overprinters that code film while it keeps moving.'],
        'tto-traverse' => ['id' => null, 'category' => 'tto', 'name' => 'Traverse Thermal Transfer Printers', 'slug' => 'traverse-thermal-transfer-printers', 'description' => 'Thermal transfer printers whose printhead travels across wide, multi-lane webs.'],
        'feeders' => ['id' => null, 'category' => 'tto', 'name' => 'Product Feeders', 'slug' => 'product-feeders', 'description' => 'Feeding systems that present pouches, bags and leaflets one at a time for coding or labelling.'],
        'metal' => ['id' => 7, 'category' => 'inspection', 'name' => 'Metal Detectors', 'slug' => 'metal-detectors', 'description' => 'In-line metal detectors for ferrous, non-ferrous and stainless-steel contaminants.'],
        'xray' => ['id' => 8, 'category' => 'inspection', 'name' => 'X-Ray Inspection Systems', 'slug' => 'x-ray-inspection-systems', 'description' => 'X-ray systems that detect dense foreign bodies and check product integrity.'],
        'checkweighers' => ['id' => null, 'category' => 'inspection', 'name' => 'Checkweighers', 'slug' => 'checkweighers', 'description' => 'In-line checkweighers for packs, cans and cases.'],
        'vacuum' => ['id' => null, 'category' => 'packing', 'name' => 'Vacuum Packaging Machines', 'slug' => 'vacuum-packaging-machines', 'description' => 'Tabletop, double-chamber and belt vacuum packers, including MAP models.'],
        'tray' => ['id' => null, 'category' => 'packing', 'name' => 'Tray Sealing Machines', 'slug' => 'tray-sealing-machines', 'description' => 'Tray sealers for sealed, MAP and skin packs.'],
        'flow' => ['id' => null, 'category' => 'packing', 'name' => 'Flow Wrapping Machines', 'slug' => 'flow-wrapping-machines', 'description' => 'Horizontal flow wrappers for single items and multipacks.'],
        'vffs' => ['id' => null, 'category' => 'packing', 'name' => 'Vertical Form Fill Seal & Pouch Machines', 'slug' => 'vertical-form-fill-seal-machines', 'description' => 'Weighing, powder filling, VFFS bagging and pre-made pouch packing systems.'],
        'end-of-line' => ['id' => null, 'category' => 'packing', 'name' => 'End of Line Packing', 'slug' => 'end-of-line-packing', 'description' => 'Carton sealing equipment for the end of the packing line.'],
    ];

    public function run(): void
    {
        DB::transaction(function () {
            $categoryIds = $this->categories();
            $subcategoryIds = $this->subcategories($categoryIds);
            $this->products($categoryIds, $subcategoryIds);
        });
    }

    private function categories(): array
    {
        $disk = Storage::disk('public');
        $ids = [];
        $position = 1;

        foreach (self::CATEGORIES as $key => $c) {
            if (!empty($c['logo_source']) && !$disk->exists($c['logo']) && $disk->exists($c['logo_source'])) {
                $disk->copy($c['logo_source'], $c['logo']);
            }
            $category = ($c['id'] ? Category::withTrashed()->find($c['id']) : null)
                ?? Category::withTrashed()->where('slug', $c['slug'])->first()
                ?? new Category();
            $category->fill([
                'name' => $c['name'],
                'slug' => $c['slug'],
                'description' => $c['description'],
                'logo' => $c['logo'],
                'logo_alt_text' => $c['logo'] ? $c['name'] : null,
                'position' => $position++,
                'display_to_home' => 'Yes',
                'status' => 1,
            ]);
            $category->deleted_at = null;
            $category->save();
            $this->meta($category, $c['meta_title'], $c['meta_description'], $c['keywords']);
            $ids[$key] = $category->id;
        }

        // The former "laser printer" category has no verified products: hide it.
        Category::whereNotIn('id', $ids)->update(['status' => 0, 'display_to_home' => 'No']);

        return $ids;
    }

    private function subcategories(array $categoryIds): array
    {
        $ids = [];
        $positions = [];

        foreach (self::SUBCATEGORIES as $key => $s) {
            $sub = ($s['id'] ? Subcategory::withTrashed()->find($s['id']) : null)
                ?? Subcategory::withTrashed()->where('slug', $s['slug'])->first()
                ?? new Subcategory();
            $categoryId = $categoryIds[$s['category']];
            $positions[$categoryId] = ($positions[$categoryId] ?? 0) + 1;
            $sub->fill([
                'category_id' => $categoryId,
                'name' => $s['name'],
                'slug' => $s['slug'],
                'description' => '<p>' . $s['description'] . '</p>',
                'image_alt_text' => $s['name'],
                'position' => $positions[$categoryId],
                'status' => 1,
            ]);
            $sub->deleted_at = null;
            $sub->save();
            $this->meta(
                $sub,
                $s['name'] . ' | Cariox',
                $s['description'],
                strtolower($s['name'])
            );
            $ids[$key] = $sub->id;
        }

        Subcategory::whereNotIn('id', $ids)->update(['status' => 0]);

        return $ids;
    }

    private function products(array $categoryIds, array $subcategoryIds): void
    {
        $catalogue = require __DIR__ . '/data/cariox_products.php';
        $brands = Brand::pluck('id', 'name');
        $keep = [];
        $positions = [];

        foreach ($catalogue as $p) {
            $product = Product::withTrashed()->where('slug', $p['slug'])->first() ?? new Product();
            $subId = $subcategoryIds[$p['subcategory']];
            $catId = $categoryIds[$p['category']];
            // Positions run across the whole category so menus list products grouped by subcategory.
            $positions[$catId] = ($positions[$catId] ?? 0) + 1;

            $product->fill([
                'category_id' => $categoryIds[$p['category']],
                'subcategory_id' => $subId,
                'brand_id' => $brands[$p['brand']] ?? null,
                'product_title' => $p['title'],
                'sub_title' => $p['sub_title'],
                'slug' => $p['slug'],
                'description' => $p['description'],
                'key_features' => $this->featuresHtml($p['features']),
                // Old brochures belonged to placeholder products; upload verified PDFs via the admin panel.
                'brochure' => null,
                'position' => $positions[$catId],
                'status' => 1,
                'display_in_home' => !empty($p['home']) ? 1 : 0,
            ]);
            $product->deleted_at = null;
            $product->save();

            $this->syncImages($product, $p['images'] ?? $this->catalogueImages($p['slug']));
            $this->meta($product, $p['meta_title'], $p['meta_description'], $p['keywords']);
            $keep[] = $product->id;
        }

        // Retire placeholder, Faker and "test" products together with their media and SEO rows.
        $retired = Product::whereNotIn('id', $keep)->pluck('id');
        if ($retired->isNotEmpty()) {
            ProductImage::whereIn('product_id', $retired)->delete();
            Meta::where('metable_type', Product::class)->whereIn('metable_id', $retired)->delete();
            Product::whereIn('id', $retired)->update(['status' => 0, 'display_in_home' => 0]);
            Product::whereIn('id', $retired)->delete();
        }
    }

    /** Gallery photos for a model: products/images/catalogue/{slug}-1.webp, {slug}-2.webp, ... */
    private function catalogueImages(string $slug): array
    {
        $files = array_filter(
            Storage::disk('public')->files('products/images/catalogue'),
            fn ($path) => preg_match('/\/' . preg_quote($slug, '/') . '-\d+\.webp$/', $path)
        );
        natsort($files);

        return array_values($files);
    }

    private function syncImages(Product $product, array $images): void
    {
        $disk = Storage::disk('public');
        $images = array_values(array_filter($images, fn ($path) => $disk->exists($path)));

        ProductImage::where('product_id', $product->id)->whereNotIn('image', $images)->delete();
        foreach ($images as $path) {
            $existing = ProductImage::withTrashed()->where('product_id', $product->id)->where('image', $path)->first();
            if ($existing) {
                $existing->restore();
            } else {
                ProductImage::create(['product_id' => $product->id, 'image' => $path]);
            }
        }
    }

    private function featuresHtml(array $features): string
    {
        $items = array_map(
            fn ($f) => '<li><strong>' . e($f[0]) . '</strong>: ' . e($f[1]) . '</li>',
            $features
        );

        return "<ul>\n" . implode("\n", $items) . "\n</ul>";
    }

    private function meta($model, string $title, string $description, ?string $keywords): void
    {
        $meta = Meta::withTrashed()->updateOrCreate(
            ['metable_type' => get_class($model), 'metable_id' => $model->id],
            [
                'meta_title' => $title,
                'meta_description' => $description,
                'meta_keyword' => $keywords,
                'og_title' => $title,
                'og_description' => $description,
                'canonical_url' => null,
            ]
        );
        if ($meta->trashed()) {
            $meta->restore();
        }
    }
}
