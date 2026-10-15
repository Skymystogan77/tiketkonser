<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Menampilkan katalog event untuk publik dengan filter kategori.
     */
    public function index(Request $request)
    {
        $query = Event::query();

        // Filter berdasarkan kategori jika dipilih oleh user
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $events = $query->latest()->get();
        return view('public.index', compact('events'));
    }

    /**
     * Menampilkan halaman master event pada panel admin.
     */
    public function adminIndex()
    {
        $events = Event::latest()->get();
        return view('admin.events.index', compact('events'));
    }

    /**
     * Menyimpan data event baru ke database dan mengunggah poster ke storage/app/public.
     */
    public function store(Request $request)
    {
        // Validasi input server-side
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:Musik,Festival,Seminar',
            'ticket_price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload file gambar ke disk public (storage/app/public/events)
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        Event::create($data);
        return redirect()->back()->with('success', 'Event berhasil ditambahkan!');
    }

    /**
     * Menghapus event beserta file gambar terkait dari storage.
     */
    public function destroy(Event $event)
    {
        // Hapus file gambar dari storage jika ada
        if ($event->image && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();
        return redirect()->back()->with('success', 'Event berhasil dihapus!');
    }
}