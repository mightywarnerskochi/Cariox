<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

/**
 * Sample customer testimonials for the home page slider.
 *
 * These are illustrative placeholders — replace them with genuine, approved customer
 * quotes via Admin > Home > Testimonials before going live.
 *
 * Safe to re-run: keyed on name.
 *
 *   php artisan db:seed --class=CarioxTestimonialSeeder
 */
class CarioxTestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Rajesh Menon',
                'designation' => 'Production Manager, Food & Beverage Manufacturer',
                'rating' => 5,
                'content' => '<p>Cariox helped us move from manual date stamping to fully automated inkjet coding on all three of our packing lines. Installation was completed over a weekend with zero impact on production, and the codes have been crisp and consistent ever since.</p>',
            ],
            [
                'name' => 'Priya Nair',
                'designation' => 'Quality Assurance Head, Pharmaceutical Packaging',
                'rating' => 5,
                'content' => '<p>Traceability is non-negotiable in our industry. The vision inspection system Cariox supplied catches every missing or unreadable batch code before it leaves the line. Their team understood our compliance requirements from day one.</p>',
            ],
            [
                'name' => 'Mohammed Faisal',
                'designation' => 'Plant Engineer, Beverage Bottling Facility',
                'rating' => 5,
                'content' => '<p>What sets Cariox apart is their after-sales support. Whenever we have needed spares or a service visit, the response has been quick and the engineers know the equipment inside out. Our downtime has dropped noticeably.</p>',
            ],
            [
                'name' => 'Anitha Krishnan',
                'designation' => 'Operations Director, FMCG Manufacturer',
                'rating' => 4,
                'content' => '<p>We needed a coding and labelling solution that could keep up with high-speed lines and frequent product changeovers. Cariox recommended the right mix of equipment and trained our operators thoroughly. Changeovers now take minutes, not hours.</p>',
            ],
            [
                'name' => 'Suresh Kumar',
                'designation' => 'Maintenance Manager, Cable & Pipe Extrusion Plant',
                'rating' => 5,
                'content' => '<p>Marking on cables and pipes at extrusion speeds is demanding, but the laser and CIJ printers from Cariox have handled it reliably day in, day out. Consumable costs are lower than our previous supplier, and the print quality is excellent.</p>',
            ],
        ];

        foreach ($testimonials as $position => $data) {
            Testimonial::updateOrCreate(
                ['name' => $data['name']],
                $data + [
                    'alt_text' => $data['name'],
                    'position' => $position + 1,
                    'status' => 1,
                ]
            );
        }
    }
}
