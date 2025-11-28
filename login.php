<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <?php include("HTML/styles.php"); ?>
    <style>
        body {
            background-color: #f0f2f5;
        }

        .login-card {
            max-width: 400px;
            margin: 80px auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card shadow login-card">
            <div class="card-body p-4">
                <h3 class="text-center mb-4 text-primary">Welcome Back</h3>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?php echo $_SESSION['error'];
                        unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION['success'];
                        unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>

                <form action="process_login.php" method="POST">

                    <div class="mb-3">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-lg">Login</button>

                    <div class="text-center mt-3">
                        <small>Don't have an account? <a href="register.php">Sign up</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>