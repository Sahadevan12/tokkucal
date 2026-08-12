<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = [
            ['loc' => route('home'), 'lastmod' => null, 'changefreq' => 'daily', 'priority' => '1.0'],
        ];

        foreach (Tool::active()->ordered()->get() as $tool) {
            $urls[] = [
                'loc' => route($tool->slug),
                'lastmod' => $tool->updated_at?->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        foreach (['about', 'contact', 'privacy-policy', 'terms', 'disclaimer'] as $routeName) {
            $urls[] = ['loc' => route($routeName), 'lastmod' => null, 'changefreq' => 'yearly', 'priority' => '0.4'];
        }

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }
}
