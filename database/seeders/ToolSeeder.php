<?php

namespace Database\Seeders;

use App\Models\Tool;
use Illuminate\Database\Seeder;

class ToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tools = [
            [
                'name' => 'GST Calculator',
                'slug' => 'gst-calculator',
                'category' => 'money',
                'short_description' => 'Calculate GST amount and total price instantly for any GST rate.',
                'description' => 'Work out GST exclusive and GST inclusive amounts in seconds. Enter any base amount or total, pick a standard slab (0%, 5%, 12%, 18%, 28%) or a custom rate, and see the base amount, GST amount and total price broken down clearly.',
                'icon' => 'receipt-percent',
                'meta_title' => 'GST Calculator India – Calculate GST Online Free',
                'meta_description' => 'Calculate GST amount instantly with our free GST calculator. Supports GST exclusive & inclusive calculation for 5%, 12%, 18%, 28% and custom rates.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'EMI Calculator',
                'slug' => 'emi-calculator',
                'category' => 'money',
                'short_description' => 'Calculate your monthly loan EMI, total interest and total payment.',
                'description' => 'Estimate the monthly instalment for any home, car or personal loan. Enter the loan amount, annual interest rate and tenure to instantly see your EMI, total interest payable and total amount repaid over the loan term.',
                'icon' => 'banknotes',
                'meta_title' => 'EMI Calculator – Calculate Loan EMI Online Free',
                'meta_description' => 'Calculate your monthly loan EMI instantly. Free EMI calculator for home loan, car loan and personal loan with total interest and payment breakup.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Percentage Calculator',
                'slug' => 'percentage-calculator',
                'category' => 'student',
                'short_description' => 'Find a percentage of a number, percentage change, or what percent one value is of another.',
                'description' => 'A four-in-one percentage tool: find X% of Y, work out what percentage X is of Y, and calculate percentage increase or decrease between two values — all in one clean tabbed calculator.',
                'icon' => 'percent-badge',
                'meta_title' => 'Percentage Calculator – Calculate Percentage Online Free',
                'meta_description' => 'Calculate percentage of a number, percentage increase, decrease and what percentage one value is of another. Free and instant.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Age Calculator',
                'slug' => 'age-calculator',
                'category' => 'student',
                'short_description' => 'Calculate exact age in years, months and days from a date of birth.',
                'description' => 'Get your precise age in years, months and days, plus total days, weeks and months lived, and a countdown to your next birthday. Accounts properly for leap years and varying month lengths.',
                'icon' => 'cake',
                'meta_title' => 'Age Calculator – Calculate Exact Age Online Free',
                'meta_description' => 'Calculate your exact age in years, months and days from your date of birth. Free online age calculator with next birthday countdown.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Salary Calculator',
                'slug' => 'salary-calculator',
                'category' => 'money',
                'short_description' => 'Estimate monthly take-home salary from your annual CTC.',
                'description' => 'Break your annual CTC down into basic, HRA, allowances and bonus, then see an estimated gross and net take-home salary after PF, professional tax and other deductions. Built for Indian salary structures.',
                'icon' => 'wallet',
                'meta_title' => 'Salary Calculator India – Calculate Take Home Salary',
                'meta_description' => 'Estimate your monthly take-home salary from CTC. Free salary calculator for Indian employees covering basic, HRA, PF and deductions.',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Discount Calculator',
                'slug' => 'discount-calculator',
                'category' => 'money',
                'short_description' => 'Calculate the final sale price after a discount, or the discount applied.',
                'description' => 'Enter the original price and discount percentage to get the discount amount and final price, or enter the original and sale price to work out the discount percentage that was applied.',
                'icon' => 'tag',
                'meta_title' => 'Discount Calculator – Calculate Sale Price Online Free',
                'meta_description' => 'Calculate discount amount and final price instantly. Free discount calculator also works in reverse to find the discount percentage applied.',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Attendance Calculator',
                'slug' => 'attendance-calculator',
                'category' => 'student',
                'short_description' => 'Track your attendance percentage and plan classes you can miss or must attend.',
                'description' => 'Enter total classes and classes attended to see your current attendance percentage. Then find out exactly how many more classes you can safely miss, or how many you must attend, to hit your target percentage.',
                'icon' => 'clipboard-check',
                'meta_title' => 'Attendance Calculator – Track Class Attendance Percentage',
                'meta_description' => 'Calculate your attendance percentage and find out how many classes you can miss or must attend to hit your target. Built for college students.',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Image Compressor',
                'slug' => 'image-compressor',
                'category' => 'image',
                'short_description' => 'Compress JPG, PNG and WebP images without losing much quality.',
                'description' => 'Drag and drop an image to shrink its file size for faster uploads and page loads. Adjust the compression quality and instantly see the new file size and percentage saved before downloading.',
                'icon' => 'photo',
                'meta_title' => 'Image Compressor – Compress JPG, PNG, WebP Online Free',
                'meta_description' => 'Compress images online without losing quality. Free image compressor for JPG, PNG and WebP with instant size comparison.',
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Image Resizer',
                'slug' => 'image-resizer',
                'category' => 'image',
                'short_description' => 'Resize images to exact dimensions or common social media presets.',
                'description' => 'Resize any image by exact width and height, keep the aspect ratio locked, or pick a ready-made preset for Instagram, WhatsApp, YouTube thumbnails, profile photos and passport photos.',
                'icon' => 'arrows-pointing-out',
                'meta_title' => 'Image Resizer – Resize Images Online Free',
                'meta_description' => 'Resize images online for Instagram, WhatsApp, YouTube and more. Free image resizer with presets and custom dimensions.',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'QR Code Generator',
                'slug' => 'qr-generator',
                'category' => 'utility',
                'short_description' => 'Generate QR codes for URLs, text, email, phone numbers and Wi-Fi.',
                'description' => 'Create a QR code for a website link, plain text, email address, phone number or Wi-Fi network. Customise size, margin and colours, then download as PNG or SVG — generated entirely in your browser.',
                'icon' => 'qr-code',
                'meta_title' => 'QR Code Generator – Create Free QR Codes Online',
                'meta_description' => 'Generate QR codes for URLs, text, email, phone and Wi-Fi instantly. Free QR code generator with PNG and SVG download, no sign-up.',
                'is_active' => true,
                'sort_order' => 10,
            ],
        ];

        foreach ($tools as $tool) {
            Tool::updateOrCreate(['slug' => $tool['slug']], $tool);
        }
    }
}
