<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateLeadStatusRequest;
use App\Models\ConsultationBooking;
use App\Services\LeadManagementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\StreamedResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(private readonly LeadManagementService $leads) {}
    public function index(Request $request): View
    {
        $filters = $request->validate(['status' => ['nullable', 'in:new,contacted,closed'], 'search' => ['nullable', 'string', 'max:100']]);
        return view('admin.leads.index', ['title' => 'حجوزات الاستشارات', 'kind' => 'bookings', 'records' => $this->leads->bookings($filters), 'filters' => $filters]);
    }
    public function update(UpdateLeadStatusRequest $request, ConsultationBooking $booking): RedirectResponse
    {
        $this->leads->updateBooking($booking, $request->validated('status'));
        return back()->with('status', 'تم تحديث حالة الحجز.');
    }
    public function export(): StreamedResponse { return $this->leads->export('bookings'); }
}
