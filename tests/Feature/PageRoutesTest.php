<?php

namespace Tests\Feature;

use Database\Seeders\ToolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PageRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ToolSeeder::class);
    }

    /**
     * @return array<string, array{0: string}>
     */
    public static function toolRoutes(): array
    {
        return [
            'gst-calculator' => ['gst-calculator'],
            'emi-calculator' => ['emi-calculator'],
            'percentage-calculator' => ['percentage-calculator'],
            'age-calculator' => ['age-calculator'],
            'salary-calculator' => ['salary-calculator'],
            'discount-calculator' => ['discount-calculator'],
            'attendance-calculator' => ['attendance-calculator'],
            'image-compressor' => ['image-compressor'],
            'image-resizer' => ['image-resizer'],
            'qr-generator' => ['qr-generator'],
        ];
    }

    #[DataProvider('toolRoutes')]
    public function test_each_tool_page_loads_successfully(string $routeName): void
    {
        $this->get(route($routeName))->assertOk();
    }

    public function test_homepage_loads_successfully(): void
    {
        $this->get(route('home'))->assertOk()->assertSee('Free Tools for Everyday Life');
    }

    /**
     * @return array<string, array{0: string}>
     */
    public static function staticRoutes(): array
    {
        return [
            'about' => ['about'],
            'contact' => ['contact'],
            'privacy-policy' => ['privacy-policy'],
            'terms' => ['terms'],
            'disclaimer' => ['disclaimer'],
        ];
    }

    #[DataProvider('staticRoutes')]
    public function test_each_static_page_loads_successfully(string $routeName): void
    {
        $this->get(route($routeName))->assertOk();
    }

    public function test_sitemap_is_valid_xml(): void
    {
        $response = $this->get(route('sitemap'));

        $response->assertOk();
        $this->assertStringStartsWith('application/xml', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('<urlset', $response->getContent());
    }

    public function test_robots_txt_references_sitemap(): void
    {
        $response = $this->get(route('robots'));

        $response->assertOk();
        $this->assertStringContainsString('Sitemap:', $response->getContent());
    }

    public function test_unknown_route_returns_404(): void
    {
        $this->get('/this-route-does-not-exist')->assertNotFound();
    }

    #[DataProvider('toolRoutes')]
    public function test_each_tool_page_has_valid_structured_data(string $routeName): void
    {
        $this->assertStructuredDataIsValid(route($routeName));
    }

    public function test_homepage_has_valid_structured_data(): void
    {
        $this->assertStructuredDataIsValid(route('home'));
    }

    public function test_about_page_has_valid_structured_data(): void
    {
        $this->assertStructuredDataIsValid(route('about'));
    }

    private function assertStructuredDataIsValid(string $url): void
    {
        $html = $this->get($url)->getContent();

        preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $matches);

        $this->assertNotEmpty($matches[1], "No JSON-LD blocks found on {$url}");

        foreach ($matches[1] as $block) {
            $decoded = json_decode(trim($block), associative: true);

            $this->assertNotNull($decoded, "JSON-LD block on {$url} is not valid JSON: {$block}");
            $this->assertSame('https://schema.org', $decoded['@context'] ?? null, "JSON-LD block on {$url} is missing a correct @context key — check for Blade's @context directive colliding with a literal '@context' string.");
        }
    }
}
