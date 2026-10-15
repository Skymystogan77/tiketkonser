@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Form Pemesanan Tiket</div>
            <div class="card-body">
                <h5>{{ $event->title }}</h5>
                <p>Harga: <strong>Rp {{ number_format($event->ticket_price, 0, ',', '.') }}</strong></p>
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="customer_email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Jumlah Tiket</label>
                        <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Konfirmasi & Bayar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection