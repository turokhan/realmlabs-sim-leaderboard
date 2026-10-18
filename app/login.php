<?php
require_once __DIR__ . '/php/auth.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
        $error = 'Your session expired. Please try again.';
    } elseif (hash_equals(LEADERBOARD_USERNAME, $username) && validAdminPassword($password)) {
        session_regenerate_id(true);
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = LEADERBOARD_USERNAME;
        refreshCsrfToken();
        header('Location: index.php');
        exit;
    } else {
        $error = 'Incorrect username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="dark">
    <title>RealmLabs Leaderboard Login</title>
    <link rel="stylesheet" href="style.css?v=20260823-7">
</head>
<body>
<div class="login-page">
    <div class="login-card">
        <div class="login-brand">REALMLABS</div>
        <h1>Sign in</h1>
        <p>Log in to add lap times to the leaderboard.</p>

        <?php if ($error): ?>
            <div class="login-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <form method="post" action="login.php">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8'); ?>">

            <div class="login-field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" autocomplete="username" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>" required autofocus>
            </div>

            <div class="login-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" autocomplete="current-password" required>
            </div>

            <button type="submit" class="login-btn">Sign In</button>
        </form>

        <div class="login-links">
            <a href="index.php" class="login-back">← Back to Leaderboard</a>
        </div>
    </div>
</div>
</body>
</html>
