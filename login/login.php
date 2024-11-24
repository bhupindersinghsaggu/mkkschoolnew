<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
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