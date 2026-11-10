<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ServicesManagementTest extends TestCase
{
    use RefreshDatabase;

    private function createAdminUser(): User
    {
        app(\App\Services\ServiceCatalogService::class)->ensureCoreServicesExist();

        $role = Role::findOrCreate('Admin', 'web');
        $user = User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin-services-'.uniqid().'@intok.com',
            'password' => Hash::make('password123'),
        ]);
        $user->assignRole($role);
        return $user;
    }

    public function test_admin_can_view_services_index_with_statistics(): void
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->get('/admin/services');

        $response->assertOk();
        $response->assertSee('إدارة الخدمات والمسارات التدريبية');
        $response->assertSee('إجمالي الخدمات المضافة');
        $response->assertSee('الخدمات النشطة على الموقع');
    }

    public function test_admin_can_create_service_with_arabic_only_fields(): void
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->post('/admin/services', [
            'title' => ['ar' => 'مسار الذكاء الاصطناعي والترجمة الآلية'],
            'slug' => ['ar' => 'ai-translation-track'],
            'summary' => ['ar' => 'برنامج تدريبي متطور يدمج الذكاء الاصطناعي مع الترجمة الاحترافية.'],
            'description' => ['ar' => 'شرح كامل وتفصيلي لمسار الذكاء الاصطناعي وتقنيات الترجمة الآلية.'],
            'badge' => ['ar' => 'مسار حديث ومطلوب'],
            'category_label' => ['ar' => 'الذكاء الاصطناعي والترجمة'],
            'level' => ['ar' => 'مبتدئ ومتقدم'],
            'duration' => ['ar' => '8 أسابيع'],
            'mode' => ['ar' => 'أونلاين تفاعلي'],
            'target_audience' => ['ar' => 'المترجمون وهواة الذكاء الاصطناعي'],
            'salary_range' => ['ar' => 'عائد مميز بالدولار'],
            'features_text' => ['ar' => "تدريب على أحدث أدوات AI\nمشاريع تطبيقية واقعية"],
            'sort_order' => 10,
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/services');
        $response->assertSessionHas('status', 'تمت إضافة الخدمة بنجاح.');

        $this->assertDatabaseHas('services', [
            'slug_ar' => 'ai-translation-track',
            'is_active' => true,
        ]);

        $created = Service::where('slug_ar', 'ai-translation-track')->first();
        $this->assertNotNull($created);
        $this->assertEquals('مسار الذكاء الاصطناعي والترجمة الآلية', $created->title['ar']);
        // English fallback
        $this->assertEquals('مسار الذكاء الاصطناعي والترجمة الآلية', $created->title['en']);
    }

    public function test_admin_can_toggle_service_active_status(): void
    {
        $admin = $this->createAdminUser();
        $service = Service::query()->where('is_active', true)->first();
        $this->assertNotNull($service);

        $response = $this->actingAs($admin)->patch("/admin/services/{$service->id}/toggle");

        $response->assertRedirect();
        $response->assertSessionHas('status', 'تم إيقاف الخدمة وحجبها عن الموقع.');
        $this->assertFalse((bool) $service->fresh()->is_active);

        // Toggle back
        $response = $this->actingAs($admin)->patch("/admin/services/{$service->id}/toggle");
        $response->assertSessionHas('status', 'تم تفعيل الخدمة وظهورها على الموقع.');
        $this->assertTrue((bool) $service->fresh()->is_active);
    }

    public function test_admin_can_update_existing_service(): void
    {
        $admin = $this->createAdminUser();
        $service = Service::query()->first();
        $this->assertNotNull($service);

        $response = $this->actingAs($admin)->put("/admin/services/{$service->id}", [
            'title' => ['ar' => 'عنوان الخدمة المعدل'],
            'slug' => ['ar' => $service->slug_ar],
            'summary' => ['ar' => 'ملخص معدل للخدمة'],
            'description' => ['ar' => 'وصف تفصيلي معدل بالكامل'],
            'badge' => ['ar' => 'شارة جديدة'],
            'sort_order' => 99,
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/services');
        $response->assertSessionHas('status', 'تم تحديث الخدمة بنجاح.');

        $this->assertEquals('عنوان الخدمة المعدل', $service->fresh()->title['ar']);
        $this->assertEquals(99, $service->fresh()->sort_order);
    }

    public function test_homepage_and_services_page_render_dynamic_database_services(): void
    {
        app(\App\Services\ServiceCatalogService::class)->ensureCoreServicesExist();

        // Change title of first service
        $service = Service::query()->where('sort_order', 1)->first();
        $this->assertNotNull($service);
        $service->update([
            'title' => ['ar' => 'مسار الكول سنتر المحدث كلياً', 'en' => 'Updated Call Center Track', 'it' => 'Corso Call Center Aggiornato'],
        ]);

        // Home page
        $homeResponse = $this->get('/ar');
        $homeResponse->assertOk();
        $homeResponse->assertSee('مسار الكول سنتر المحدث كلياً');

        // Services index page
        $servicesResponse = $this->get('/ar/services');
        $servicesResponse->assertOk();
        $servicesResponse->assertSee('مسار الكول سنتر المحدث كلياً');
    }
}
