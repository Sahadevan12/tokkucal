<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Tool;

trait ResolvesTool
{
    protected function tool(string $slug): Tool
    {
        return Tool::active()->where('slug', $slug)->firstOrFail();
    }

    /**
     * @return array{title: string, description: string, canonical: string}
     */
    protected function seoFor(Tool $tool): array
    {
        return [
            'title' => $tool->meta_title,
            'description' => $tool->meta_description,
            'canonical' => route($tool->slug),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function jsonLdFor(Tool $tool): array
    {
        $categories = [
            'money' => 'FinanceApplication',
            'student' => 'EducationalApplication',
            'image' => 'MultimediaApplication',
            'utility' => 'UtilitiesApplication',
        ];

        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebApplication',
            'name' => $tool->name,
            'description' => $tool->meta_description,
            'url' => route($tool->slug),
            'applicationCategory' => $categories[$tool->category] ?? 'UtilitiesApplication',
            'operatingSystem' => 'Any',
            'offers' => [
                '@type' => 'Offer',
                'price' => '0',
                'priceCurrency' => 'INR',
            ],
        ];
    }

    /**
     * @return array<int, array{label: string, url: string|null}>
     */
    protected function breadcrumbsFor(Tool $tool): array
    {
        return [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => $tool->name, 'url' => null],
        ];
    }
}
