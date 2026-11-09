<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_requires_authentication(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_admin_user_can_open_the_inertia_dashboard(): void
    {
        $role = Role::findOrCreate('Admin', 'web');
        $user = User::query()->create(['name' => 'Admin User', 'email' => 'admin@example.com', 'password' => Hash::make('strong-password-123')]);
        $user->assignRole($role);

        $this->actingAs($user)->get('/admin')->assertOk()->assertInertia(fn (Assert $page) => $page->component('Admin/Dashboard')->has('stats.services'));
    }

    public function test_admin_user_can_view_and_update_site_settings(): void
    {
        $role = Role::findOrCreate('Admin', 'web');
        $user = User::query()->create(['name' => 'Admin User', 'email' => 'admin-settings@example.com', 'password' => Hash::make('strong-password-123')]);
        $user->assignRole($role);

        $this->actingAs($user)->get('/admin/settings')->assertOk()->assertSee('إدارة محتوى ونصوص الموقع بالكامل');

        $response = $this->actingAs($user)->put('/admin/settings', [
            'site_name' => ['ar' => 'أكاديمية إنتوك الدولية', 'en' => 'INTOK ACADEMY', 'it' => 'INTOK ACADEMY'],
            'tagline' => ['ar' => 'بوابتك نحو إيطاليا وسوق العمل الدولي', 'en' => 'Connecting You to the World', 'it' => 'Connetterti al Mondo'],
            'hero_badge' => ['ar' => 'شعار مخصص', 'en' => 'Custom badge', 'it' => 'Badge'],
            'hero_title' => ['ar' => 'عنوان تجريبي جديد', 'en' => 'New Title', 'it' => 'Nuovo Titolo'],
            'hero_text' => ['ar' => 'نص تجريبي جديد للهيرو', 'en' => 'New Text', 'it' => 'Nuovo Testo'],
            'hero_cta' => ['ar' => 'ابدأ الآن', 'en' => 'Start Now', 'it' => 'Inizia Ora'],
            'contact_phone' => '01008238323',
            'whatsapp_number' => '+201008238323',
            'contact_email' => 'info@intokacademy.com',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status', 'تم حفظ إعدادات الموقع بنجاح.');

        $this->get('/ar')->assertOk()->assertSee('عنوان تجريبي جديد');
    }

    public function test_client_without_role_cannot_login_to_admin(): void
    {
        $client = User::query()->create(['name' => 'Client User', 'email' => 'client@example.com', 'password' => Hash::make('secret-pass-123')]);

        $response = $this->post('/admin/login', [
            'email' => 'client@example.com',
            'password' => 'secret-pass-123',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_client_without_role_cannot_access_admin_dashboard(): void
    {
        $client = User::query()->create(['name' => 'Client User', 'email' => 'client@example.com', 'password' => Hash::make('secret-pass-123')]);

        $this->actingAs($client)->get('/admin')->assertForbidden();
    }

    public function test_admin_can_view_and_create_moderator(): void
    {
        $adminRole = Role::findOrCreate('Admin', 'web');
        $admin = User::query()->create(['name' => 'Admin User', 'email' => 'superadmin@example.com', 'password' => Hash::make('pass-123456')]);
        $admin->assignRole($adminRole);

        $this->actingAs($admin)->get('/admin/moderators')->assertOk()->assertSee('إدارة المشرفين والمديرين');

        $response = $this->actingAs($admin)->post('/admin/moderators', [
            'name' => 'مشرف تجريبي',
            'email' => 'moderator@example.com',
            'password' => 'moderator-pass-123',
            'password_confirmation' => 'moderator-pass-123',
            'role' => 'Editor',
        ]);

        $response->assertRedirect('/admin/moderators');
        $this->assertDatabaseHas('users', ['email' => 'moderator@example.com', 'name' => 'مشرف تجريبي']);

        $newModerator = User::query()->where('email', 'moderator@example.com')->firstOrFail();
        $this->assertTrue($newModerator->hasRole('Editor'));
    }

    public function test_newly_created_moderator_can_login_and_access_dashboard(): void
    {
        $editorRole = Role::findOrCreate('Editor', 'web');
        $moderator = User::query()->create(['name' => 'Moderator One', 'email' => 'mod1@example.com', 'password' => Hash::make('mod-pass-123')]);
        $moderator->assignRole($editorRole);

        $loginResponse = $this->post('/admin/login', [
            'email' => 'mod1@example.com',
            'password' => 'mod-pass-123',
        ]);

        $loginResponse->assertRedirect('/admin');
        $this->assertAuthenticatedAs($moderator);

        $this->actingAs($moderator)->get('/admin')->assertOk();
    }

    public function test_moderator_cannot_access_moderators_management(): void
    {
        $editorRole = Role::findOrCreate('Editor', 'web');
        $moderator = User::query()->create(['name' => 'Moderator One', 'email' => 'mod2@example.com', 'password' => Hash::make('mod-pass-123')]);
        $moderator->assignRole($editorRole);

        $this->actingAs($moderator)->get('/admin/moderators')->assertForbidden();
    }

    public function test_admin_cannot_delete_self_or_primary_admin(): void
    {
        $adminRole = Role::findOrCreate('Admin', 'web');
        $admin = User::query()->create(['name' => 'Admin User', 'email' => 'admin@intok.com', 'password' => Hash::make('pass-123456')]);
        $admin->assignRole($adminRole);

        $response = $this->actingAs($admin)->delete("/admin/moderators/{$admin->id}");
        $response->assertSessionHasErrors(['error']);
        $this->assertDatabaseHas('users', ['id' => $admin->id]);

        $profileDeleteResponse = $this->actingAs($admin)->delete('/admin/profile', ['password' => 'pass-123456']);
        $profileDeleteResponse->assertSessionHasErrors(['password']);
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_all_admin_subpages_render_with_unified_layout(): void
    {
        $adminRole = Role::findOrCreate('Admin', 'web');
        $admin = User::query()->create(['name' => 'Admin User', 'email' => 'admin-subpages@example.com', 'password' => Hash::make('pass-123456')]);
        $admin->assignRole($adminRole);

        $this->actingAs($admin)->get('/admin/services')->assertOk()->assertSee('إدارة الخدمات والمسارات التدريبية');
        $this->actingAs($admin)->get('/admin/services/create')->assertOk()->assertSee('إضافة خدمة جديدة');
        $this->actingAs($admin)->get('/admin/team')->assertOk()->assertSee('إدارة فريق العمل');
        $this->actingAs($admin)->get('/admin/team/create')->assertOk()->assertSee('إضافة عضو فريق جديد');
        $this->actingAs($admin)->get('/admin/inquiries')->assertOk()->assertSee('إدارة الاستفسارات');
        $this->actingAs($admin)->get('/admin/bookings')->assertOk()->assertSee('حجوزات الاستشارات');
        $this->actingAs($admin)->get('/admin/registrations')->assertOk()->assertSee('تسجيلات العملاء');
        $this->actingAs($admin)->get('/admin/pages')->assertOk()->assertSee('الصفحات');
        $this->actingAs($admin)->get('/admin/testimonials')->assertOk()->assertSee('قصص النجاح');
        $this->actingAs($admin)->get('/admin/moderators')->assertOk()->assertSee('إدارة المشرفين والمديرين');
        $this->actingAs($admin)->get('/admin/profile')->assertOk()->assertSee('الملف الشخصي والحساب');
    }
}
