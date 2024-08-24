<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-container {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container h1 {
            margin-bottom: 1rem;
            font-size: 1.5rem;
            color: #333;
            text-align: center;
        }
        .login-container input {
            margin-bottom: 1rem;
            padding: 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        .login-container button {
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            width: 100%;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #0056b3;
        }
        .login-container .error {
            color: red;
            margin-bottom: 1rem;
        }
        .login-container .register-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
        }
        .login-container .register-link a {
            color: #007bff;
            text-decoration: none;
        }
        .login-container .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="page-title">
        <h1>Mini Vendor Registration System</h1>
    </div>
    @if (session('success'))
        <div class="success">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    <div class="login-container">
        <h1 style="font-size: 2rem;">Login</h1>
        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
        </div>
    </div>
</body>
</html>
