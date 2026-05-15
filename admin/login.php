<?php
session_start();
include '../includes/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM admins WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: index.php");
            exit();
        } else {
            $message = "<div class='alert alert-danger'>Password vul!</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>Admin khuje pawa jayni!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - CoinStore.bd</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: white; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: #1e293b; padding: 30px; border-radius: 15px; width: 100%; max-width: 400px; border: 1px solid #334155; }
        .btn-main { background: #3b82f6; color: white; border: none; }
        .btn-main:hover { background: #2563eb; }
    </style>
</head>
<body>
    <div class="login-card">
        <h3 class="text-center mb-4">Admin Login</h3>
        <?php echo $message; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control bg-dark text-white border-secondary" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control bg-dark text-white border-secondary" required>
            </div>
            <button type="submit" class="btn btn-main w-100">Login</button>
        </form>
    </div>
</body>
</html>
