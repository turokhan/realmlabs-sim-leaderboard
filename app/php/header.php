<header class="site-header">
    <div class="site-header-inner">
        <nav class="top-game-nav" aria-label="Leaderboard game">
            <a class="rl-pill top-game-pill<?php echo empty($isGt7) ? ' active' : ''; ?>" href="index.php">F1</a>
            <a class="rl-pill top-game-pill<?php echo !empty($isGt7) ? ' active' : ''; ?>" href="index.php?game=gt7">Gran Turismo 7</a>

            <?php if (!empty($isLoggedIn)): ?>
                <button class="rl-pill top-add-time" type="button" onclick="openForm()">+ Add New Time</button>
            <?php endif; ?>
        </nav>

        <nav class="auth-nav" aria-label="Account">
            <?php if (!empty($isLoggedIn)): ?>
                <span class="signed-in-user"><?php echo htmlspecialchars($_SESSION['username'] ?? 'admin', ENT_QUOTES, 'UTF-8'); ?></span>
                <a class="rl-pill rl-pill-ghost" href="logout.php">Logout</a>
            <?php else: ?>
                <a class="rl-pill" href="login.php">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
