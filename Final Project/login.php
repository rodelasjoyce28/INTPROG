<?php
session_start();

$usersFile = __DIR__ . '/data/users.json';
$users = json_decode(file_get_contents($usersFile), true) ?: [];

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    foreach ($users as $user) {
        if (($user['username'] ?? '') === $username && ($user['password'] ?? '') === $password) {
            $_SESSION['user'] = [
                'username' => $user['username'],
                'role' => $user['role'],
            ];
            header('Location: menu.php');
            exit;
        }
    }

    $error = 'Invalid username or password. Please try again.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Cafe Byte</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="auth-body">
    <div class="auth-box">
        <div class="auth-header">
            <p class="eyebrow">Welcome</p>
            <h1>Login to Cafe Byte</h1>
        </div>

        <?php if ($error !== ''): ?>
            <div class="alert danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php" class="auth-form">
            <input type="hidden" name="login" value="1">

            <label>
                Username
                <input type="text" name="username" placeholder="admin" required>
            </label>

            <label>
                Password
                <input type="password" name="password" placeholder="admin123" required>
            </label>

            <button type="submit" class="primary-btn full-width">Login</button>
        </form>

        <div class="demo-box">
            <strong>Demo Accounts</strong>
            <p>admin / admin123</p>
            <p>customer / customer123</p>
        </div>

        <p class="switch-link">
            <a href="index.php">Back to Home</a>
        </p>
    </div>
</body>
</html>
