<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .page-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 2rem;
        }
        .register-container {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .register-container h1 {
            margin-bottom: 1.5rem;
            font-size: 1.75rem;
            color: #333;
            text-align: center;
        }
        .register-container input {
            margin-bottom: 1rem;
            padding: 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        .register-container button {
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            width: 100%;
            cursor: pointer;
            font-size: 1rem;
        }
        .register-container button:hover {
            background-color: #0056b3;
        }
        .register-container .error {
            color: red;
            margin-bottom: 1rem;
            text-align: center;
        }
        .register-container .login-link {
            text-align: center;
            margin-top: 1rem;
        }
        .register-container .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .register-container .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="page-title">
        <h1>Mini Vendor Registration System</h1>
    </div>
    <div class="register-container">
        <h1>Register</h1>
        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <input type="text" name="contact_number" placeholder="Contact Number" value="{{ old('contact_number') }}" required oninput="validateContactNumber(this)" required>
            <script>
                function validateContactNumber(input) {
                    // Allow only numeric input
                    input.value = input.value.replace(/[^0-9]/g, '');
                }
            </script>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
        </div>
    </div>
</body>
</html>
