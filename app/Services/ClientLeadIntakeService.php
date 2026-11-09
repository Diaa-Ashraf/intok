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
        $booking = DB::transaction(fn (): ConsultationBooking => ConsultationBooking::query()->create($data));
        $this->notifyAdmin('حجز استشارة جديد', ['الاسم' => $booking->name, 'الهاتف' => $booking->phone, 'الموعد' => $booking->preferred_at->format('Y-m-d H:i')], 'booking', $booking->id, $booking->name);

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
