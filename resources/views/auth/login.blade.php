<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <form action="{{ route('login') }}" method="POST">
            @csrf <!-- CSRF token for security -->
            <h1>Login</h1>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class='bx bxs-envelope'></i> <!-- Icon for email input -->
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i> <!-- Icon for password input -->
            </div>
            <div class="remember-forgot">
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
                <a href="#">Forgot password</a> <!-- Link to reset password (functionality not implemented here) -->
            </div>
            <button type="submit" class="btn">Login</button> <!-- Submit button -->
            <div class="register-link">
                <p>Don't have an account? <a href="#">Register</a></p> <!-- Link to the registration page (implement separately) -->
            </div>
            @if ($errors->any()) <!-- Display error message if authentication fails -->
                <div class="error">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </form>
    </div>
</body>
</html>
