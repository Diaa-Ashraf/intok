<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateInquiryStatusRequest;
use App\Models\Inquiry;
use App\Services\InquiryManagementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\StreamedResponse;
use Illuminate\View\View;

class InquiryController extends Controller
{
    public function __construct(private readonly InquiryManagementService $inquiries)
    {
    }

    public function index(Request $request): View
    {
        $filters = $request->validate(['status' => ['nullable', 'in:new,contacted,closed'], 'search' => ['nullable', 'string', 'max:100']]);

        return view('admin.inquiries.index', ['inquiries' => $this->inquiries->paginate($filters), 'filters' => $filters]);
    }

    public function updateStatus(UpdateInquiryStatusRequest $request, Inquiry $inquiry): RedirectResponse
    {
        $this->inquiries->updateStatus($inquiry, $request->validated('status'));

        return back()->with('status', 'تم تحديث حالة الاستفسار.');
    }

    public function export(): StreamedResponse
    {
        return $this->inquiries->exportCsv();
    }
}
