<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account</title>
    <?php include("HTML/styles.php"); ?>
    <style>
        body {
            background-color: #f0f2f5;
        }

        .register-card {
            max-width: 500px;
            margin: 50px auto;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card shadow register-card">
            <div class="card-body p-5">
                <h2 class="text-center mb-4 text-primary">Create Account</h2>

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

                <form action="create_user.php" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. John Doe" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-lg">Sign Up</button>

                    <div class="text-center mt-3">
                        <small>Already have an account? <a href="login.php">Login here</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>