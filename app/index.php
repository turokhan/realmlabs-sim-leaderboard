<?php
require_once __DIR__ . '/php/auth.php';
$isLoggedIn = isLoggedIn();
$game = (isset($_GET['game']) && $_GET['game'] === 'gt7') ? 'gt7' : 'f1';
$isGt7 = $game === 'gt7';

// Preserve local/subdirectory hosting; do not redirect to RealmLabs.
$canonicalUrl = null;
$pageTitle = $isGt7
    ? 'Gran Turismo 7 Circuit Experience Leaderboard | RealmLabs'
    : 'F1 Sim Racing Leaderboard | RealmLabs';
$pageDescription = $isGt7
    ? 'Compare Gran Turismo 7 Circuit Experience times, track records and player rankings on the RealmLabs sim racing leaderboard.'
    : 'Compare F1 fastest laps, track records and player rankings on the RealmLabs self-hosted sim racing leaderboard.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="dark">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large">
    <link rel="stylesheet" href="style.css?v=20260823-11">
</head>
<body>
    <?php include 'php/header.php'; ?>

    <main class="page-shell">
        <section class="leaderboard-hero banner-hero" aria-label="Sim Racing Leaderboard"><div class="public-hero"><span>REALMLABS · OPEN SOURCE</span><h1>SIM RACING LEADERBOARD</h1><p>F1 &amp; Gran Turismo 7 · Friendly competition. Serious lap times.</p></div></section>

        <?php if (isset($_SESSION['lap_message']) && is_array($_SESSION['lap_message'])):
            $lapMessage = $_SESSION['lap_message'];
            unset($_SESSION['lap_message']);
        ?>
            <div class="lap-alert <?php echo ($lapMessage[0] ?? '') === 'success' ? 'lap-alert-success' : 'lap-alert-error'; ?>" role="status">
                <?php echo htmlspecialchars((string)($lapMessage[1] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>
        <section class="leaderboard-card">
            <div class="results-container">
                <?php
                if ($isGt7) {
                    include 'php/gt7-leaderboard.php';
                } else {
                    include 'php/leaderboard.php';
                }
                ?>
            </div>
        </section>
    </main>

    <?php if ($isLoggedIn): ?>
        <div id="popupForm" class="popup-form" role="dialog" aria-modal="true" aria-labelledby="add-time-title">
            <div class="popup-content">
                <div class="popup-header">
                    <div>
                        <div class="popup-kicker"><?php echo $isGt7 ? 'Gran Turismo 7' : 'F1'; ?></div>
                        <h2 id="add-time-title">Add New Time</h2>
                    </div>
                    <button class="modal-x" type="button" onclick="closeForm()" aria-label="Close">&times;</button>
                </div>

                <?php
                if ($isGt7) {
                    include 'php/gt7-form.php';
                } else {
                    include 'php/form.php';
                }
                ?>
                <button class="close-btn" type="button" onclick="closeForm()">Close</button>
            </div>
        </div>
    <?php endif; ?>

    <?php include 'php/footer.php'; ?>
    <script src="scripts.js?v=20260823-10"></script>
</body>
</html>
