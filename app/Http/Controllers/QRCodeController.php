<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesTool;
use Illuminate\View\View;

class QRCodeController extends Controller
{
    use ResolvesTool;

    public function index(): View
    {
        $tool = $this->tool('qr-generator');

        return view('tools.qr-generator', [
            ...$this->seoFor($tool),
            'tool' => $tool,
            'jsonLd' => $this->jsonLdFor($tool),
            'breadcrumbs' => $this->breadcrumbsFor($tool),
        ]);
    }
}
