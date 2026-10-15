@extends('layouts.app')

@section('content')
<h2>Master Data Event</h2>

<div class="card mb-4 mt-3 shadow-sm">
    <div class="card-header bg-primary text-white fw-bold">Tambah Event Baru</div>
    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
            @csrf
            <div class="col-md-4">
                <label class="form-label">Judul Event</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Kategori</label>
                <select name="category" class="form-select" required>
                    <option value="Musik">Musik</option>
                    <option value="Festival">Festival</option>
                    <option value="Seminar">Seminar</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Harga Tiket</label>
                <input type="number" name="ticket_price" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Poster / Gambar</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="2" required></textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Simpan Event</button>
            </div>
        </form>

    </div>
</div>

<table class="table table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>Poster</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($events as $event)
        <tr>
            <td style="width: 80px;" class="text-center">
                @if($event->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($event->image))
                    <img src="{{ asset('storage/' . $event->image) }}" width="60" height="60" style="object-fit: cover;" class="rounded">
                @elseif($event->image && file_exists(public_path($event->image)))
                    <img src="{{ asset($event->image) }}" width="60" height="60" style="object-fit: cover;" class="rounded">
                @else
                    <span class="badge bg-secondary">No Image</span>
                @endif
            </td>
            <td>{{ $event->title }}</td>
            <td>{{ $event->category }}</td>
            <td>Rp {{ number_format($event->ticket_price, 0, ',', '.') }}</td>
            <td>
                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Hapus event ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">Belum ada data event.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection