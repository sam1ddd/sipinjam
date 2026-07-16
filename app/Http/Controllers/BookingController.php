<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Facility;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Form pengajuan peminjaman (User)
    public function create()
    {
        $facilities = Facility::where('status', 'available')->get();
        return view('bookings.create', compact('facilities'));
    }

    // Simpan pengajuan (User)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'purpose' => 'required|string|max:1000',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
        ]);

        // Cek bentrok jadwal: apakah ada booking lain (pending/approved)
        // di fasilitas yang sama, dengan rentang waktu yang tumpang tindih
        $conflict = Booking::where('facility_id', $validated['facility_id'])
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($query) use ($validated) {
                $query->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>', $validated['start_time']);
            })
            ->exists();

        if ($conflict) {
            return back()->withInput()->withErrors([
                'start_time' => 'Fasilitas sudah dipesan pada rentang waktu tersebut. Silakan pilih waktu lain.',
            ]);
        }

        Booking::create([
            'user_id' => auth()->id(),
            'facility_id' => $validated['facility_id'],
            'purpose' => $validated['purpose'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.index')->with('success', 'Pengajuan peminjaman berhasil dikirim, menunggu persetujuan admin.');
    }

    // Riwayat peminjaman milik User yang login
    public function myBookings()
    {
        $bookings = Booking::with('facility')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    // Daftar semua pengajuan (Admin)
    public function manage()
    {
        $bookings = Booking::with(['user', 'facility'])
            ->latest()
            ->paginate(10);

        return view('bookings.manage', compact('bookings'));
    }

    // Setujui pengajuan (Admin)
    public function approve(Booking $booking)
    {
        $booking->update(['status' => 'approved', 'rejection_reason' => null]);
        return back()->with('success', 'Peminjaman disetujui.');
    }

    // Tolak pengajuan (Admin)
    public function reject(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        $booking->update(['status' => 'rejected', 'rejection_reason' => $validated['rejection_reason']]);
        return back()->with('success', 'Peminjaman ditolak.');
    }
}