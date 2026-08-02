<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affiliate Login</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); width: 100%; max-width: 400px; }
        h2 { margin-bottom: 1rem; text-align: center; color: #333; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: .5rem; color: #666; }
        input[type="email"], input[type="password"] { width: 100%; padding: .75rem; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: .75rem; background: #007bff; color: #fff; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error { color: red; font-size: 0.875rem; margin-top: .25rem; }
        .text-center { text-align: center; margin-top: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Affiliate Login</h2>
        <form method="POST" action="{{ route('affiliate.login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" required autofocus value="{{ old('email') }}">
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <div class="text-center">
            <a href="{{ route('affiliate.register') }}">Create an account</a>
        </div>
    </div>
</body>
</html>
