<?php

namespace App\Services;

use App\Models\Inquiry;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\StreamedResponse;
use Illuminate\Support\Facades\DB;

class InquiryManagementService
{
    /** @param array<string, string> $filters */
    public function paginate(array $filters, int $perPage = 20): LengthAwarePaginator
    {
        return Inquiry::query()->select(['id', 'name', 'email', 'phone', 'subject', 'message', 'status', 'locale', 'created_at'])
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->when($filters['search'] ?? null, function ($query, string $search): void {
                $query->where(function ($nested) use ($search): void {
                    $nested->where('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->orWhere('phone', 'like', '%'.$search.'%')->orWhere('subject', 'like', '%'.$search.'%');
                });
            })
            ->latest('id')->paginate($perPage)->withQueryString();
    }

    public function updateStatus(Inquiry $inquiry, string $status): Inquiry
    {
        return DB::transaction(function () use ($inquiry, $status): Inquiry {
            $inquiry->update(['status' => $status]);

            return $inquiry->refresh();
        });
    }

    public function exportCsv(): StreamedResponse
    {
        return response()->streamDownload(function (): void {
            $output = fopen('php://output', 'wb');
            if ($output === false) {
                return;
            }
            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, ['الرقم', 'الاسم', 'البريد', 'الهاتف', 'الموضوع', 'الرسالة', 'الحالة', 'اللغة', 'التاريخ']);
            Inquiry::query()->select(['id', 'name', 'email', 'phone', 'subject', 'message', 'status', 'locale', 'created_at'])->orderBy('id')->chunkById(500, function ($inquiries) use ($output): void {
                foreach ($inquiries as $inquiry) {
                    fputcsv($output, array_map([$this, 'safeCsvCell'], [$inquiry->id, $inquiry->name, $inquiry->email, $inquiry->phone, $inquiry->subject, $inquiry->message, $inquiry->status, $inquiry->locale, $inquiry->created_at?->toDateTimeString()]));
                }
            });
            fclose($output);
        }, 'intok-inquiries.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function safeCsvCell(mixed $value): string
    {
        $cell = (string) ($value ?? '');
        return preg_match('/^[=+@\-\t\r]/u', $cell) === 1 ? "'".$cell : $cell;
    }
}
