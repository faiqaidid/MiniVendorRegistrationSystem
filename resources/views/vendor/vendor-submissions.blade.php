<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Submissions</title>
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
            padding-bottom: 150px; /* Adjust the top padding here */
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
            text-align: center;
        }
        .table {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            font-size: 0.8rem;
        }
        .table thead {
            background-color: #1e1e1e;
            color: #fff;
        }
        .table thead th {
            text-align: center;
        }
        .table tbody tr {
            border-bottom: 1px solid #dee2e6;
        }
        .table tbody td {
            vertical-align: middle;
            text-align: center;
            padding: 1rem;
        }
        .table tbody td a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }
        .table tbody td a:hover {
            text-decoration: underline;
        }
        .table tbody td img {
            max-width: 150px;
            border-radius: 8px;
            cursor: pointer;
        }
        .form-control {
            display: inline-block;
            width: auto;
            margin: 0;
        }
        .form-control {
            width: 100%;
            box-sizing: border-box;
        }
        .custom-badge.approved {
            background-color: green !important;
            color: white !important;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .custom-badge.rejected {
            background-color: red !important;
            color: white !important;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .custom-badge.pending {
            background-color: grey !important;
            color: white !important;
            padding: 5px 10px;
            border-radius: 4px;
        }


    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Menu</h2>
        <nav>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.dashboard') }}">Home</a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('admin.profile') }}">Profile</a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('vendor.submissions') }}">Vendor Submissions</a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('vendor.accepted') }}">Accepted Vendor</a>
                </li>
                <!-- Add more links as needed -->
            </ul>
        </nav>
        <div class="logout-btn">
            {{-- <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a> --}}
        </div>
    </div>

    <div class="content">
        <div class="navbar">
            <h1>Vendor Submissions</h1>
            <div class="user-info">
                <span>Welcome Admin, {{ Auth::user()->name }}</span>
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

        <div class="card">
            <div class="card-header">
                List Vendor Submission
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Contact Number</th>
                            <th>Business License</th>
                            <th>Incorporation Certificate</th>
                            <th>Insurance Certificates</th>
                            <th>Business Logo</th>
                            <th>Premises Photo</th>
                            <th>Product Images</th>
                            <th>Submitted Date</th>
                            <th>Status</th>
                            <th>Status Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vendors as $index => $vendor)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $vendor->name }}</td>
                                <td>{{ $vendor->contact_number }}</td>
                                <td>{{ $vendor->business_license ?? 'N/A' }}</td>
                                <td>
                                    @if($vendor->incorporation_certificate)
                                        <a href="{{ Storage::url($vendor->incorporation_certificate) }}" target="_blank">View PDF</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($vendor->insurance_certificates)
                                        @foreach(json_decode($vendor->insurance_certificates) as $certificate)
                                            <a href="{{ Storage::url($certificate) }}" target="_blank">View Certificate</a><br>
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($vendor->business_logo)
                                        <a href="{{ Storage::url($vendor->business_logo) }}" target="_blank">View Image</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($vendor->premises_photo)
                                        <a href="{{ Storage::url($vendor->premises_photo) }}" target="_blank">View Image</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($vendor->product_images)
                                        @foreach(json_decode($vendor->product_images) as $image)
                                            <a href="{{ Storage::url($image) }}" target="_blank">View Image</a><br>
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $vendor->submitted_at }}</td>
                                <td>
                                    @if($vendor->status == 'Approved')
                                        <span class="custom-badge approved">{{ strtoupper($vendor->status) }}</span>
                                    @elseif($vendor->status == 'Rejected')
                                        <span class="custom-badge rejected">{{ strtoupper($vendor->status) }}</span>
                                    @else
                                        <span class="custom-badge pending">{{ strtoupper($vendor->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('vendor.update', $vendor->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select class="form-control" name="status">
                                            <option value="Pending" {{ $vendor->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Approved" {{ $vendor->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="Rejected" {{ $vendor->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary mt-2">Update</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
