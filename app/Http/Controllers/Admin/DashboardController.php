<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\ConsultationBooking;
use App\Models\ClientRegistration;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'services' => Service::query()->count(),
                'teamMembers' => TeamMember::query()->count(),
                'newInquiries' => Inquiry::query()->where('status', 'new')->count(),
                'newBookings' => ConsultationBooking::query()->where('status', 'new')->count(),
                'newRegistrations' => ClientRegistration::query()->where('status', 'new')->count(),
                'moderators' => \App\Models\User::query()->count(),
            ],
            'userName' => auth()->user()->name,
            'canManageContent' => auth()->user()->hasRole('Admin'),
        ]);
    }
}
