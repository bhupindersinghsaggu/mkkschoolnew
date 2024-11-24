<?php require('connection'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="style.css" />

</head>

<body>
    <div class="register-container">
        <h2>Register</h2>
        <form action="" method="POST" autocomplete="off">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="Username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="submit-btn" value="Register" name="register">Register</button>
        </form>
        <div class="form-footer">
            Already have an account? <a href="/login">Login here</a>
        </div>
    </div>
</body>

</html>