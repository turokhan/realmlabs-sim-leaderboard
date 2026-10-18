<?php
require_once __DIR__ . '/auth.php';
function f1h($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function f1millis($value) { $p = explode(':', $value); $s = explode('.', $p[1] ?? '0.000'); return (int)$p[0]*60000 + (int)$s[0]*1000 + (int)($s[1] ?? 0); }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireLogin();
    if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
        $_SESSION['lap_message'] = ['error', 'Session expired. Please log in again and retry.'];
        header('Location: ../index.php?game=f1', true, 303); exit;
    }
    $player = trim((string)($_POST['player'] ?? ''));
    $track = trim((string)($_POST['track'] ?? ''));
    $minutes = (string)($_POST['minutes'] ?? '');
    $seconds = (string)($_POST['seconds'] ?? '');
    $milliseconds = (string)($_POST['milliseconds'] ?? '');
    $validTime = preg_match('/^[0-9]$/D', $minutes) && preg_match('/^(?:[0-9]|[1-5][0-9])$/D', $seconds)
        && preg_match('/^[0-9]{1,3}$/D', $milliseconds);
    $min = $validTime ? (int)$minutes : 0;
    $sec = $validTime ? (int)$seconds : 0;
    $ms = $validTime ? (int)$milliseconds : 0;
    $valid = $player !== '' && strlen($player) <= 80 && $track !== '' && strlen($track) <= 255
        && $validTime && ($min*60000+$sec*1000+$ms) > 0;
    if ($valid) {
        $check = $conn->prepare('SELECT race_name FROM calendar_2024 WHERE race_name = ? LIMIT 1');
        $check->bind_param('s', $track); $check->execute(); $check->store_result();
        $valid = $check->num_rows === 1; $check->close();
    }
    if ($valid) {
        $lap = sprintf('%02d:%02d.%03d', $min, $sec, $ms);
        $today = date('Y-m-d');
        $stmt = $conn->prepare('INSERT INTO f1_leaderboards (Player, LapTime, Track, Date) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $player, $lap, $track, $today);
        $stmt->execute(); $stmt->close();
        $_SESSION['lap_message'] = ['success', 'F1 lap ' . $lap . ' saved for ' . $player . '.'];
    } else {
        $_SESSION['lap_message'] = ['error', 'Lap not saved. Check driver, circuit and lap time (minutes:seconds.milliseconds).'];
    }
    header('Location: ../index.php?game=f1' . ($track !== '' ? '&track=' . urlencode($track) : ''), true, 303);
    exit;
}
$tracks = [];
$r = $conn->query('SELECT DISTINCT race_name FROM calendar_2024 ORDER BY race_name');
while ($row = $r->fetch_assoc()) $tracks[] = $row['race_name'];
$requested = isset($_GET['track']) && is_string($_GET['track']) ? $_GET['track'] : '';
$selected = in_array($requested, $tracks, true) ? $requested : ($tracks[0] ?? '');
if (!in_array($requested, $tracks, true)) {
    $populated = $conn->query('SELECT Track FROM f1_leaderboards GROUP BY Track ORDER BY COUNT(*) DESC, Track LIMIT 1')->fetch_assoc();
    if ($populated && in_array($populated['Track'], $tracks, true)) $selected = $populated['Track'];
}
echo '<section class="ranking-section"><h2>F1 Circuit Leaderboard</h2><p class="ranking-note">Fastest personal best per driver, ranked from quickest to slowest.</p>';
echo '<form class="track-filter" action="index.php" method="get"><input type="hidden" name="game" value="f1"><label for="f1-filter">Circuit</label><select id="f1-filter" name="track" onchange="this.form.submit()">';
foreach ($tracks as $name) echo '<option value="' . f1h($name) . '"' . ($name === $selected ? ' selected' : '') . '>' . f1h($name) . '</option>';
echo '</select><button type="submit">Show rankings</button></form>';
if ($selected !== '') {
    $stmt = $conn->prepare('SELECT Player, LapTime FROM f1_leaderboards WHERE Track = ? ORDER BY id ASC');
    $stmt->bind_param('s', $selected); $stmt->execute(); $r = $stmt->get_result(); $bests=[];
    while ($row = $r->fetch_assoc()) {
        if (!preg_match('/^\d{1,2}:[0-5]\d\.\d{3}$/', $row['LapTime'])) continue;
        $name = trim($row['Player']); if ($name === '') continue;
        $key = strtolower($name); $milliseconds = f1millis($row['LapTime']);
        if (!isset($bests[$key]) || $milliseconds < $bests[$key]['ms']) $bests[$key] = ['player'=>$name,'ms'=>$milliseconds,'lap'=>$row['LapTime']];
    }
    $stmt->close();
    usort($bests, static function ($a, $b) { return ($a['ms'] <=> $b['ms']) ?: strcasecmp($a['player'],$b['player']); });
    if ($bests) { echo '<div class="table-scroll"><table class="ranking-table"><thead><tr><th>Pos</th><th>Driver</th><th>Personal Best</th></tr></thead><tbody>';
        foreach ($bests as $i => $entry) echo '<tr' . ($i === 0 ? ' class="fastest"' : '') . '><td>' . ($i+1) . '</td><td>' . f1h($entry['player']) . '</td><td>' . f1h($entry['lap']) . '</td></tr>';
        echo '</tbody></table></div>';
    } else echo '<p class="empty-state">No lap times for this circuit yet.</p>';
}
echo '</section><section class="recent-section"><h2>Latest 10 F1 Lap Times</h2>';
$r = $conn->query('SELECT LapTime, Track, Player FROM f1_leaderboards ORDER BY id DESC LIMIT 10');
if ($r->num_rows) { echo '<div class="table-scroll"><table><thead><tr><th>Lap Time</th><th>Track</th><th>Player</th></tr></thead><tbody>';
while ($row = $r->fetch_assoc()) echo '<tr><td>' . f1h($row['LapTime']) . '</td><td>' . f1h($row['Track']) . '</td><td>' . f1h($row['Player']) . '</td></tr>';
echo '</tbody></table></div>'; }
else echo '<p class="empty-state">No times recorded yet.</p>';
echo '</section>';
?>
