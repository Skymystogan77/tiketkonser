@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Event</h2>
    
    <form action="{{ route('catalog') }}" method="GET" class="d-flex gap-2">
        <select name="category" class="form-select">
            <option value="">Semua Kategori</option>
            <option value="Musik" {{ request('category') == 'Musik' ? 'selected' : '' }}>Musik</option>
            <option value="Festival" {{ request('category') == 'Festival' ? 'selected' : '' }}>Festival</option>
            <option value="Seminar" {{ request('category') == 'Seminar' ? 'selected' : '' }}>Seminar</option>
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
</div>

<div class="row">
    @forelse($events as $event)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                
                {{-- Cek jika ada gambar di storage/app/public, tampilkan. Jika tidak ada, tampilkan placeholder No Image --}}
                @if($event->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($event->image))
                    <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                @elseif($event->image && file_exists(public_path($event->image)))
                    <img src="{{ asset($event->image) }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                @else
                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center fw-bold" style="height: 180px;">
                        [ No Image ]
                    </div>
                @endif

                <div class="card-body">
                    <span class="badge bg-primary mb-2">{{ $event->category }}</span>
                    <h5 class="card-title">{{ $event->title }}</h5>
                    <p class="card-text text-muted">{{ $event->description }}</p>
                    <h6 class="text-success fw-bold">Rp {{ number_format($event->ticket_price, 0, ',', '.') }}</h6>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    <a href="{{ route('checkout.show', $event->id) }}" class="btn btn-success w-100">Beli Tiket</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-secondary text-center">Belum ada data event.</div>
        </div>
    @endforelse
</div>
@endsection