<?php

namespace App\Services;

use App\Events\InquiryReceived;
use App\Models\Inquiry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryReceivedMail;

class InquiryIntakeService
{
    /** @param array<string, mixed> $data */
    public function create(array $data): Inquiry
    {
        unset($data['website']);
        $inquiry = DB::transaction(fn (): Inquiry => Inquiry::query()->create($data));
        DB::afterCommit(function () use ($inquiry): void {
            try {
                InquiryReceived::dispatch($inquiry);
            } catch (\Throwable $exception) {
                report($exception);
            }
            Mail::to(config('intok.admin_email'))->queue(new InquiryReceivedMail($inquiry));
        });

        return $inquiry;
    }
}
