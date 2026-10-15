@extends('layouts.app')

@section('content')
<h2>Rekap Pesanan Tiket (Admin)</h2>

<table class="table table-bordered mt-3 align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID Order</th>
            <th>Nama Pemesan</th>
            <th>Email</th>
            <th>Detail Event</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th style="width: 160px;">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
            @foreach($order->orderDetails as $detail)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->customer_email }}</td>
                <td>{{ $detail->event->title ?? '-' }}</td>
                <td>{{ $detail->quantity }} Tiket</td>
                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td>
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Confirmed" {{ $order->status == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </td>
            </tr>
            @endforeach
        @empty
            <tr>
                <td colspan="7" class="text-center">Belum ada pesanan masuk.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection