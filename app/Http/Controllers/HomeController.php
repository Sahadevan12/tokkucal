<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $tools = Tool::active()->ordered()->get();

        return view('pages.home', [
            'title' => config('tokkucal.site_name').' – '.config('tokkucal.tagline'),
            'description' => config('tokkucal.description'),
            'canonical' => route('home'),
            'toolsByCategory' => $tools->groupBy('category'),
            'popularTools' => $tools->take(6),
            'jsonLd' => [
                '@context' => 'https://schema.org',
                '@type' => 'WebSite',
                'name' => config('tokkucal.site_name'),
                'url' => route('home'),
                'description' => config('tokkucal.description'),
            ],
        ]);
    }
}
