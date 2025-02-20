<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Registration Form</title>
    <style>
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-content {
            background-color: #f8f9fa;
            /* Light grey background */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-purple {
            background-color: #6f42c1;
            color: white;
        }
    </style>
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
    <!-- <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <div class="navbar-nav ms-auto">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                    <a class="nav-link" href="#">Dashboard</a>
                    <a class="nav-link" href="#">Logout</a>
                </div>
            </div>
        </div>
    </nav> -->

    <section class="form-container">
        <div class="col-6 col-md-4 form-content">
            <div class="p-3 p-md-4 p-xl-5">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-5">
                            <h2 class="h3">Registration</h2>
                            <h3 class="fs-6 fw-normal text-secondary m-0">Enter your details to register</h3>
                        </div>
                    </div>
                </div>
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="row gy-3 gy-md-4 overflow-hidden">
                        <div class="col-12">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                                required>
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="name@example.com" required>
                        </div>
                        <div class="col-12">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        <div class="col-12">
                            <label for="confirmPassword" class="form-label">Confirm Your Password <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="confirm_password" id="confirmPassword"
                                required>
                        </div>
                        <div class="col-12">
                            <div class="d-grid">
                                <button class="btn btn-purple" type="submit">Sign up</button>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span>Have an account already?</span> <a href="{{ route('login') }}">Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

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