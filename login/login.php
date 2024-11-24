<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background: #f4f4f9;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .register-container {
        background: #ffffff;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }

    .register-container h2 {
        text-align: center;
        margin-bottom: 1rem;
        color: #333;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #555;
    }

    .form-group input {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
    }

    .form-group input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 3px rgba(0, 123, 255, 0.5);
    }

    .submit-btn {
        background: #007bff;
        color: #fff;
        padding: 0.8rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
        width: 100%;
    }

    .submit-btn:hover {
        background: #0056b3;
    }

    .form-footer {
        margin-top: 1rem;
        text-align: center;
        font-size: 0.9rem;
        color: #666;
    }

    .form-footer a {
        color: #007bff;
        text-decoration: none;
    }

    .form-footer a:hover {
        text-decoration: underline;
    }
    </style>
</head>



<body>
    <div class="login-container">
        <h1>Login</h1>
        <form action="" method="POST">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required="">
            </div>
            <div class=" input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required="">
            </div>
            <button type="submit" class="login-button" name="login_btn">Login</button>
            <!-- <div class="options">
                <a href="/forgot-password">Forgot Password?</a>
                <a href="/register">Create an account</a>
            </div> -->
        </form>
    </div>
</body>

</html>