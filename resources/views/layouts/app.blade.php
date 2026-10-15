<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Box</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('catalog') }}">Ticket Box</a>
            <div>
                <a href="{{ route('catalog') }}" class="btn btn-outline-light btn-sm me-2">Katalog</a>
                
                @auth
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-warning btn-sm me-2">Rekap Order</a>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-info btn-sm me-2">Master Event</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-warning btn-sm">Login Admin</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        @if(session('success')) 
            <div class="alert alert-success">{{ session('success') }}</div> 
        @endif
        @if(session('error')) 
            <div class="alert alert-danger">{{ session('error') }}</div> 
        @endif

        @yield('content')
    </div>

</body>
</html>