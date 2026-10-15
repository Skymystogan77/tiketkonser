<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Menampilkan halaman checkout tiket untuk pengunjung (publik).
     */
    public function showCheckout(Event $event)
    {
        return view('public.checkout', compact('event'));
    }

    /**
     * Memproses pesanan tiket menggunakan Database Transaction multi-tabel (orders & order_details).
     */
    public function processCheckout(Request $request)
    {
        // Validasi input server-side
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'event_id' => 'required|exists:events,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Memulai transaksi database agar data tersimpan konsisten (atomicity)
        DB::beginTransaction();
        try {
            $event = Event::findOrFail($request->event_id);
            $subtotal = $event->ticket_price * $request->quantity;

            // 1. Simpan data header order ke tabel orders
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'total_price' => $subtotal,
                'status' => 'Pending',
            ]);

            // 2. Simpan detail item tiket ke tabel order_details (relasi foreign key order_id)
            OrderDetail::create([
                'order_id' => $order->id,
                'event_id' => $event->id,
                'quantity' => $request->quantity,
                'subtotal' => $subtotal,
            ]);

            // Commit transaksi jika semua query berhasil dijalankan
            DB::commit();
            return redirect()->route('catalog')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            // Rollback jika terjadi kegagalan atau error sistem
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses pesanan.');
        }
    }

    /**
     * Menampilkan rekap transaksi pesanan masuk untuk administrator.
     */
    public function adminOrders()
    {
        $orders = Order::with('orderDetails.event')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Memperbarui status pembayaran pesanan tiket (Pending / Confirmed / Cancelled).
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:Pending,Confirmed,Cancelled']);
        $order->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status pesanan berhasil diubah!');
    }
}