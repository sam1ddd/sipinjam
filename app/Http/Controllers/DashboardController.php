<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Facility;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $stats = [
                'total_facilities' => Facility::count(),
                'total_bookings' => Booking::count(),
                'pending' => Booking::where('status', 'pending')->count(),
                'approved' => Booking::where('status', 'approved')->count(),
                'rejected' => Booking::where('status', 'rejected')->count(),
            ];

            $popularFacilities = Facility::withCount('bookings')
                ->orderByDesc('bookings_count')
                ->take(5)
                ->get();

            return view('dashboard', compact('stats', 'popularFacilities'));
        }

        // Untuk user biasa, tampilkan ringkasan riwayat singkat miliknya
        $myBookings = Booking::with('facility')
            ->where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('myBookings'));
    }
}