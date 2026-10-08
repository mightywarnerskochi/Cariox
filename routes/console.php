<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('sitemap:generate', function (\App\Services\SitemapGenerator $generator) {
    $count = $generator->generate();
    $this->info("Sitemap generated with {$count} URLs at public/sitemap.xml");
})->purpose('Generate public/sitemap.xml from the active website content');

Artisan::command('llms:generate', function (\App\Services\LlmsTxtGenerator $generator) {
    $count = $generator->generate();
    $this->info("llms.txt generated with {$count} links at public/llms.txt");
})->purpose('Generate public/llms.txt from the active website content');
