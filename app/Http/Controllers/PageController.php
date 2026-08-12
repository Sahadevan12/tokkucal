<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactFormMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('pages.about', [
            'title' => 'About Us – '.config('tokkucal.site_name'),
            'description' => 'Learn about Tokkucal, why we built it, and how we keep every calculator free and fast.',
            'canonical' => route('about'),
        ]);
    }

    public function contact(): View
    {
        return view('pages.contact', [
            'title' => 'Contact Us – '.config('tokkucal.site_name'),
            'description' => 'Get in touch with the Tokkucal team for feedback, bug reports or tool suggestions.',
            'canonical' => route('contact'),
        ]);
    }

    public function sendContact(ContactRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $recipient = config('tokkucal.contact_email');

        if ($recipient) {
            Mail::to($recipient)->send(new ContactFormMail(
                $data['name'],
                $data['email'],
                $data['subject'],
                $data['message'],
            ));
        } else {
            Log::warning('Contact form submitted but CONTACT_EMAIL is not configured.', $data);
        }

        return redirect()->route('contact')->with('status', 'Thanks — your message has been sent. We\'ll get back to you soon.');
    }

    public function privacy(): View
    {
        return view('pages.privacy-policy', [
            'title' => 'Privacy Policy – '.config('tokkucal.site_name'),
            'description' => 'Read the Tokkucal privacy policy to understand what data we collect and how it is used.',
            'canonical' => route('privacy-policy'),
        ]);
    }

    public function terms(): View
    {
        return view('pages.terms', [
            'title' => 'Terms of Service – '.config('tokkucal.site_name'),
            'description' => 'The terms and conditions for using Tokkucal calculators and tools.',
            'canonical' => route('terms'),
        ]);
    }

    public function disclaimer(): View
    {
        return view('pages.disclaimer', [
            'title' => 'Disclaimer – '.config('tokkucal.site_name'),
            'description' => 'Tokkucal calculators are for informational purposes only. Read the full disclaimer.',
            'canonical' => route('disclaimer'),
        ]);
    }
}
