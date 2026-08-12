<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ImageToolsTest extends TestCase
{
    public function test_compressor_accepts_a_valid_jpeg(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg', 800, 600);

        $response = $this->post(route('image-compressor.process'), [
            'image' => $file,
            'quality' => 70,
        ], ['Accept' => 'application/json']);

        $response->assertOk();
        $response->assertJsonStructure(['data_uri', 'mime', 'original_size', 'compressed_size', 'percent_saved', 'width', 'height']);
        $this->assertSame(800, $response->json('width'));
        $this->assertSame(600, $response->json('height'));
    }

    public function test_compressor_rejects_missing_file(): void
    {
        $response = $this->postJson(route('image-compressor.process'), ['quality' => 70]);

        $response->assertStatus(422)->assertJsonValidationErrors(['image']);
    }

    public function test_compressor_rejects_disallowed_file_type(): void
    {
        $file = UploadedFile::fake()->create('script.php', 10, 'application/x-php');

        $response = $this->post(route('image-compressor.process'), [
            'image' => $file,
            'quality' => 70,
        ], ['Accept' => 'application/json']);

        $response->assertStatus(422)->assertJsonValidationErrors(['image']);
    }

    public function test_compressor_rejects_oversized_file(): void
    {
        $file = UploadedFile::fake()->create('huge.jpg', 11 * 1024, 'image/jpeg');

        $response = $this->post(route('image-compressor.process'), [
            'image' => $file,
            'quality' => 70,
        ], ['Accept' => 'application/json']);

        $response->assertStatus(422)->assertJsonValidationErrors(['image']);
    }

    public function test_compressor_rejects_quality_out_of_range(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg', 400, 400);

        $response = $this->post(route('image-compressor.process'), [
            'image' => $file,
            'quality' => 150,
        ], ['Accept' => 'application/json']);

        $response->assertStatus(422)->assertJsonValidationErrors(['quality']);
    }

    public function test_resizer_scales_proportionally_when_aspect_ratio_locked(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg', 1600, 1200);

        $response = $this->post(route('image-resizer.process'), [
            'image' => $file,
            'width' => 400,
            'height' => 300,
            'maintain_aspect_ratio' => 1,
            'output_format' => 'png',
        ], ['Accept' => 'application/json']);

        $response->assertOk();
        $this->assertSame(400, $response->json('width'));
        $this->assertSame(300, $response->json('height'));
    }

    public function test_resizer_requires_both_dimensions_without_aspect_ratio(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg', 1600, 1200);

        $response = $this->post(route('image-resizer.process'), [
            'image' => $file,
            'width' => 400,
            'maintain_aspect_ratio' => 0,
            'output_format' => 'jpg',
        ], ['Accept' => 'application/json']);

        $response->assertStatus(422)->assertJsonValidationErrors(['height']);
    }

    public function test_resizer_rejects_invalid_output_format(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg', 400, 400);

        $response = $this->post(route('image-resizer.process'), [
            'image' => $file,
            'width' => 200,
            'height' => 200,
            'output_format' => 'bmp',
        ], ['Accept' => 'application/json']);

        $response->assertStatus(422)->assertJsonValidationErrors(['output_format']);
    }
}
