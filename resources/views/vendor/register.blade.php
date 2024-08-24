<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .sidebar {
            width: 250px;
            background: #343a40;
            color: #fff;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            padding: 1rem;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar h2 {
            margin-top: 0;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 0.75rem;
            border-radius: 4px;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .sidebar .logout-btn {
            margin-top: auto;
        }
        .content {
            margin-left: 250px;
            padding: 2rem;
            width: calc(100% - 250px);
            overflow-y: auto;
            background: #f8f9fa;
        }
        .navbar {
            background: #007bff;
            color: #fff;
            padding: 0.75rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar h1 {
            margin: 0;
            font-size: 1.5rem;
        }
        .navbar .user-info {
            display: flex;
            align-items: center;
        }
        .navbar .user-info span {
            margin-right: 1rem;
        }
        .navbar .user-info a {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            background: #dc3545;
            transition: background 0.3s;
        }
        .navbar .user-info a:hover {
            background: #c82333;
        }
        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 4rem); /* Adjust for navbar height */
            padding-top: 80px; /* Adjust the top padding here */
        }
        .card {
            width: 100%;
            max-width: 1200px;
            margin: 1rem;
        }
        .card-header {
            background: #007bff;
            color: #fff;
            text-align: center;
            padding: 1rem;
            font-size: 1.25rem;
        }
        .card-body {
            padding: 2rem;
        }
    </style>
</head>
<body>
    
    <!-- Your form goes here -->

    <div class="sidebar">
        <h2>Menu</h2>
        <nav>
            {{-- <a href="#">Home</a>
            <a href="#">Profile</a>
            <a href="#">Settings</a> --}}
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.dashboard') }}">Home</a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('user.profile') }}">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('vendor.register') }}">Vendor Registration</a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('vendor.submission') }}">View My Submission</a>
                </li>
                <!-- Add more links as needed -->
            </ul>
            <!-- Add more sidebar links as needed -->
        </nav>
        <div class="logout-btn">
            {{-- <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a> --}}
        </div>
    </div>

    <div class="content">
        <div class="navbar">
            <h1>Mini Vendor Registration System</h1>
            <div class="user-info">
                <span>Welcome, {{ Auth::user()->name }}</span>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            </div>
        </div><br>
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="card-container">
            <div class="card">
                <div class="card-header">
                    Vendor Registration
                </div>
                <div class="card-body">
                    <form action="{{ route('vendor.register') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="business_license">Business License</label>
                            <input type="text" name="business_license" id="business_license" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tax_id">Tax ID</label>
                            <input type="text" name="tax_id" id="tax_id" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="incorporation_certificate">Incorporation Certificate (Allowed formats: PDF, JPG, PNG, JPEG)</label>
                            <input type="file" name="incorporation_certificate" id="incorporation_certificate" accept=".pdf, .jpg, .png, .jpeg" class="form-control-file">
                        </div>
                        <div class="form-group">
                            <label for="insurance_certificates">Insurance Certificates (Allowed formats: PDF, JPG, PNG, JPEG)</label>
                            <input type="file" name="insurance_certificates[]" id="insurance_certificates" accept=".pdf, .jpg, .png, .jpeg" class="form-control-file" multiple>
                        </div>
                        <div class="form-group">
                            <label for="business_logo">Business Logo (Allowed formats: JPG, PNG, JPEG)</label>
                            <input type="file" name="business_logo" id="business_logo" class="form-control-file" accept=".jpg, .png, .jpeg">
                        </div>
                        <div class="form-group">
                            <label for="premises_photo">Premises Photo (Allowed formats: JPG, PNG, JPEG)</label>
                            <input type="file" name="premises_photo" id="premises_photo" class="form-control-file" accept=".jpg, .png, .jpeg">
                        </div>
                        <div class="form-group">
                            <label for="product_images">Product Images (Allowed formats: JPG, PNG, JPEG)</label>
                            <input type="file" name="product_images[]" id="product_images" class="form-control-file" accept=".jpg, .png, .jpeg" multiple>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
