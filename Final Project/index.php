<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Cafe Byte</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="landing-body">
    <header class="topbar">
        <div class="brand">Cafe Byte</div>
        <nav>
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="menu.php">Menu</a>
        </nav>
    </header>

    <main class="landing-container">
        <section class="hero landing-panel">
            <div>
                <h1>Order your favorite meals in a clean, modern app.</h1>
                <p>Fresh food, fast checkout, and a smooth ordering experience made for everyday dining.</p>
                <div class="landing-actions">
                    <a href="login.php" class="primary-btn">Login</a>
                    <a href="menu.php" class="secondary-btn">View Menu</a>
                </div>
            </div>
            <div class="status-card">
                <span>Fresh & Fast</span>
                <strong>Easy ordering, simple checkout, delicious meals.</strong>
            </div>
        </section>
    </main>
</body>
</html>
