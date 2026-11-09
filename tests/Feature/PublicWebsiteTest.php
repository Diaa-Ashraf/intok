<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class PublicWebsiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_to_the_default_arabic_locale(): void
    {
        $this->get('/')->assertRedirect('/ar');
    }

    public function test_localized_homepage_and_service_detail_render(): void
    {
        $this->seed();
        $service = Service::query()->firstOrFail();

        $this->get('/ar')->assertOk()->assertSee('<html lang="ar" dir="rtl">', false);
        $this->get('/en')->assertOk()->assertSee('<html lang="en" dir="ltr">', false);
        $this->get('/it')->assertOk()->assertSee('<html lang="it" dir="ltr">', false);
        $servicePage = $this->get('/en/services/'.$service->slug_en);
        $servicePage->assertOk()->assertSee($service->title['en']);
        $servicePage->assertSee('hreflang="ar"', false)->assertSee('hreflang="it"', false);
    }

    public function test_contact_form_stores_the_inquiry_and_redirects_with_a_success_flash(): void
    {
        Mail::fake();
        config(['broadcasting.default' => 'log']);

        $response = $this->post('/ar/contact', [
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'subject' => 'Study in Italy',
            'message' => 'I need help with my application.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status');
        Mail::assertQueued(\App\Mail\InquiryReceivedMail::class, fn ($mail): bool => $mail->hasTo(config('intok.admin_email')));
        $this->assertDatabaseHas('inquiries', [
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'locale' => 'ar',
            'status' => 'new',
        ]);
    }

    public function test_honeypot_rejects_automated_inquiry_submissions(): void
    {
        $response = $this->from('/ar/contact')->post('/ar/contact', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'message' => 'Automated message.',
            'website' => 'https://spam.example',
        ]);

        $response->assertRedirect('/ar/contact')->assertSessionHasErrors('website');
        $this->assertSame(0, Inquiry::query()->count());
    }
}
