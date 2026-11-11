<?php

namespace App\Services;

use App\Events\AdminLeadReceived;
use App\Mail\AdminLeadReceivedMail;
use App\Models\ClientRegistration;
use App\Models\ConsultationBooking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ClientLeadIntakeService
{
    /** @param array<string, mixed> $data */
    public function register(array $data, string $locale): ClientRegistration
    {
        unset($data['website']);
        $registration = DB::transaction(fn (): ClientRegistration => ClientRegistration::query()->create([...$data, 'locale' => $locale]));
        $this->notifyAdmin('تسجيل عميل جديد', ['الاسم' => $registration->name, 'الهاتف' => $registration->phone, 'الدولة' => $registration->country], 'registration', $registration->id, $registration->name);

        return $registration;
    }

    /** @param array<string, mixed> $data */
    public function book(array $data): ConsultationBooking
    {
        unset($data['website']);
        if (empty($data['preferred_at']) && !empty($data['preferred_contact_time'])) {
            $data['preferred_at'] = now()->addDay()->setHour(10)->setMinute(0)->setSecond(0);
        } elseif (empty($data['preferred_at'])) {
            $data['preferred_at'] = now();
        }

        $booking = DB::transaction(fn (): ConsultationBooking => ConsultationBooking::query()->create($data));
        $contactTime = $booking->preferred_contact_time ?? ($booking->preferred_at ? $booking->preferred_at->format('Y-m-d H:i') : 'خلال ساعات العمل');
        $this->notifyAdmin('حجز استشارة جديد', [
            'الاسم' => $booking->name,
            'الهاتف' => $booking->phone,
            'النوع' => $booking->booking_type === 'study_abroad' ? 'استشارة دراسة بالخارج' : 'استشارة عامة في الخدمات',
            'الموعد' => $contactTime,
        ], 'booking', $booking->id, $booking->name);

        return $booking;
    }

    /** @param array<string, string> $details */
    private function notifyAdmin(string $subject, array $details, string $type, int $id, string $name): void
    {
        DB::afterCommit(function () use ($subject, $details, $type, $id, $name): void {
            try { AdminLeadReceived::dispatch($id, $name, $subject, $type); } catch (\Throwable $exception) { report($exception); }
            try { Mail::to(config('intok.admin_email'))->queue(new AdminLeadReceivedMail($subject, $details)); } catch (\Throwable $exception) { report($exception); }
        });
    }
}
