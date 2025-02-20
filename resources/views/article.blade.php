<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TomoGaku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">TomoGaku</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    @if (Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                        </li>
                        @if (Auth::user()->role == 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin') }}">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-7">
                <img src="{{ asset($content->image) }}" alt="" style="width:100%" class="mb-4">
                <h3>{{ $content->title }}</h3>
                <p>Dibuat : {{ $content->created_at->diffForHumans() }}</p>

                @php
                    $content_desc = explode("\n", $content->content);
                @endphp

                @foreach ($content_desc as $c)
                    <p>{{ $c }}</p>
                @endforeach
            </div>

            <div class="col-5">
                {{-- make commentar input --}}
                <form action="{{ route('comment', $content->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="content_id">
                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment</label>
                        <textarea class="form-control" id="comment" name="content" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn" style="background-color: #6A0DAD; border-color: #6A0DAD; color: white;">
                        Submit
                    </button>


                    @error('comment')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </form>

                {{-- show comments --}}
                <div class="mt-5">
                    <h4>Comments</h4>
                    @foreach ($content->comments as $comment)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $comment->author->name }}</h5>
                                <p class="card-text">{{ $comment->content }}</p>
                                <p class="card-text"><small
                                        class="text-muted">{{ $comment->created_at->diffForHumans() }}</small></p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success') || session('error'))
        @php
            $title = session('success') ? 'success' : 'error';
            $message = session('success') ? session('success') : session('error');
        @endphp

        <script>
            Swal.fire({
                title: '{{ ucfirst($title) }}',
                text: "{{ $message }}",
                icon: '{{ $title }}',
                confirmButtonColor: '#435ebe',
                confirmButtonText: 'Done',
                onConfirm: function() {
                    window.location.href = "{{ url()->current() }}";
                }
            })
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                title: 'error',
                text: "{{ $errors->first() }}",
                icon: 'error',
                confirmButtonColor: '#435ebe',
                confirmButtonText: 'Done'
            })
        </script>
    @endif
</body>

</html>