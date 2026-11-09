<?php

namespace App\Services;

use App\Models\ClientRegistration;
use App\Models\ConsultationBooking;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\StreamedResponse;
use Illuminate\Support\Facades\DB;

class LeadManagementService
{
    /** @param array<string, string> $filters */
    public function registrations(array $filters): LengthAwarePaginator
    {
        return ClientRegistration::query()->select(['id', 'name', 'phone', 'email', 'country', 'education_level', 'service_id', 'locale', 'status', 'created_at'])->with('service:id,title')
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->when($filters['search'] ?? null, fn ($query, string $search) => $query->where(fn ($nested) => $nested->where('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->orWhere('phone', 'like', '%'.$search.'%')->orWhere('country', 'like', '%'.$search.'%')))
            ->latest('id')->paginate(20)->withQueryString();
    }

    /** @param array<string, string> $filters */
    public function bookings(array $filters): LengthAwarePaginator
    {
        return ConsultationBooking::query()->select(['id', 'name', 'phone', 'email', 'service_id', 'preferred_at', 'language', 'notes', 'status', 'created_at'])->with('service:id,title')
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->when($filters['search'] ?? null, fn ($query, string $search) => $query->where(fn ($nested) => $nested->where('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->orWhere('phone', 'like', '%'.$search.'%')))
            ->latest('id')->paginate(20)->withQueryString();
    }

    public function updateBooking(ConsultationBooking $booking, string $status): void
    {
        DB::transaction(fn () => $booking->update(['status' => $status]));
    }

    public function updateRegistration(ClientRegistration $registration, string $status): void
    {
        DB::transaction(fn () => $registration->update(['status' => $status]));
    }

    public function export(string $kind): StreamedResponse
    {
        $booking = $kind === 'bookings';
        $model = $booking ? ConsultationBooking::class : ClientRegistration::class;
        $columns = $booking
            ? ['id', 'name', 'email', 'phone', 'service_id', 'preferred_at', 'language', 'notes', 'status', 'created_at']
            : ['id', 'name', 'email', 'phone', 'country', 'education_level', 'service_id', 'locale', 'status', 'created_at'];
        $headers = $booking
            ? ['الرقم', 'الاسم', 'البريد', 'الهاتف', 'الخدمة', 'الموعد', 'اللغة', 'الملاحظات', 'الحالة', 'تاريخ الطلب']
            : ['الرقم', 'الاسم', 'البريد', 'الهاتف', 'الدولة', 'المستوى التعليمي', 'الخدمة', 'اللغة', 'الحالة', 'تاريخ الطلب'];

        return response()->streamDownload(function () use ($model, $columns, $headers): void {
            $output = fopen('php://output', 'wb');
            if ($output === false) return;
            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, $headers);
            $model::query()->select($columns)->orderBy('id')->chunkById(500, function ($records) use ($output, $columns): void {
                foreach ($records as $record) {
                    fputcsv($output, array_map([$this, 'safeCell'], array_map(fn (string $column) => $record->{$column}, $columns)));
                }
            });
            fclose($output);
        }, 'intok-'.$kind.'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function safeCell(mixed $value): string
    {
        $cell = (string) ($value ?? '');
        return preg_match('/^[=+@\-\t\r]/u', $cell) === 1 ? "'".$cell : $cell;
    }
}
