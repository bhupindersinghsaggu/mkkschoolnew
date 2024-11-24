<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f3f4f6;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.login-container {
    background: #ffffff;
    padding: 20px 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

h1 {
    margin-bottom: 20px;
    color: #333333;
}

.input-group {
    margin-bottom: 15px;
    text-align: left;
}

.input-group label {
    font-size: 14px;
    color: #555555;
    margin-bottom: 5px;
    display: block;
}

.input-group input {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #cccccc;
    border-radius: 4px;
}

.input-group input:focus {
    border-color: #007bff;
    outline: none;
}

.login-button {
    background-color: #007bff;
    color: #ffffff;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
}

.login-button:hover {
    background-color: #0056b3;
}

.options {
    margin-top: 15px;
}

.options a {
    font-size: 14px;
    color: #007bff;
    text-decoration: none;
    margin: 0 5px;
}

.options a:hover {
    text-decoration: underline;
}
</style>

<body>
    <div class="login-container">
        <h1>Login</h1>
        <form action="/login" method="POST">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="login-button">Login</button>
            <div class="options">
                <a href="/forgot-password">Forgot Password?</a>
                <a href="/register">Create an account</a>
            </div>
        </form>
    </div>
</body>

</html>