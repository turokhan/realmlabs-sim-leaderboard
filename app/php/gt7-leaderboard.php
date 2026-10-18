<?php
require_once __DIR__ . '/auth.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireLogin();
    if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
        $_SESSION['lap_message'] = ['error', 'Session expired. Please log in again and retry.'];
        header('Location: ../index.php?game=gt7', true, 303); exit;
    }
    $player = trim((string)($_POST['player'] ?? ''));
    $minutes = (string)($_POST['minutes'] ?? '');
    $seconds = (string)($_POST['seconds'] ?? '');
    $milliseconds = (string)($_POST['milliseconds'] ?? '');
    $track = filter_var($_POST['track_id'] ?? null, FILTER_VALIDATE_INT);
    $validTime = preg_match('/^[0-9]$/D', $minutes) && preg_match('/^(?:[0-9]|[1-5][0-9])$/D', $seconds)
        && preg_match('/^[0-9]{1,3}$/D', $milliseconds);
    $min = $validTime ? (int)$minutes : 0;
    $sec = $validTime ? (int)$seconds : 0;
    $ms = $validTime ? (int)$milliseconds : 0;
    $valid = $player !== '' && mb_strlen_safe($player) <= 100 && $validTime && ($min*60000+$sec*1000+$ms) > 0
        && $track !== false && $track !== null && $track > 0;
    if ($valid) {
        $check = $conn->prepare('SELECT id FROM gt7_tracks WHERE id = ?');
        $check->bind_param('i', $track); $check->execute(); $check->store_result();
        $valid = $check->num_rows === 1; $check->close();
    }
    if ($valid) {
        $lapMs = $min*60000 + $sec*1000 + $ms;
        $lap = sprintf('%02d:%02d.%03d', $min, $sec, $ms);
        $today = date('Y-m-d');
        $stmt = $conn->prepare('INSERT INTO gt7_entries (player, track_id, lap_time, lap_time_ms, date) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sisis', $player, $track, $lap, $lapMs, $today);
        $stmt->execute(); $stmt->close();
        $_SESSION['lap_message'] = ['success', 'GT7 lap ' . $lap . ' saved for ' . $player . '.'];
    } else {
        $_SESSION['lap_message'] = ['error', 'Lap not saved. Check driver, circuit and lap time (minutes:seconds.milliseconds).'];
    }
    header('Location: ../index.php?game=gt7' . (($track !== false && $track > 0) ? '&track=' . $track : ''), true, 303);
    exit;
}
function mb_strlen_safe($text) { return function_exists('mb_strlen') ? mb_strlen($text, 'UTF-8') : strlen($text); }
function gt7h($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
$tracks = [];
$r = $conn->query('SELECT id, track_name FROM gt7_tracks ORDER BY sort_order, track_name');
while ($entry = $r->fetch_assoc()) $tracks[(int)$entry['id']] = $entry['track_name'];
$requested = filter_var($_GET['track'] ?? null, FILTER_VALIDATE_INT);
$selected = $requested && isset($tracks[$requested]) ? $requested : (array_key_first($tracks) ?? 0);
if (!$requested || !isset($tracks[$requested])) {
    $bestPopulated = $conn->query('SELECT track_id FROM gt7_entries GROUP BY track_id ORDER BY COUNT(*) DESC, track_id LIMIT 1')->fetch_assoc();
    if ($bestPopulated && isset($tracks[(int)$bestPopulated['track_id']])) $selected = (int)$bestPopulated['track_id'];
}
echo '<section class="ranking-section"><h2>GT7 Circuit Leaderboard</h2><p class="ranking-note">Fastest personal best per driver. Every attempt is kept in the database.</p>';
echo '<form class="track-filter" action="index.php" method="get"><input type="hidden" name="game" value="gt7"><label for="gt7-filter">Circuit</label><select id="gt7-filter" name="track" onchange="this.form.submit()">';
foreach ($tracks as $id => $name) echo '<option value="' . $id . '"' . ($id === $selected ? ' selected' : '') . '>' . gt7h($name) . '</option>';
echo '</select><button type="submit">Show rankings</button></form>';
if ($selected) {
    $stmt = $conn->prepare('SELECT MIN(player) AS player, MIN(lap_time_ms) AS best_ms FROM gt7_entries WHERE track_id = ? GROUP BY LOWER(TRIM(player)) ORDER BY best_ms ASC, player ASC');
    $stmt->bind_param('i', $selected); $stmt->execute(); $res = $stmt->get_result();
    if ($res->num_rows) {
        echo '<div class="table-scroll"><table class="ranking-table"><thead><tr><th>Pos</th><th>Driver</th><th>Personal Best</th></tr></thead><tbody>'; $position = 0;
        while ($row = $res->fetch_assoc()) { $position++; $ms = (int)$row['best_ms']; $lap = sprintf('%02d:%02d.%03d', intdiv($ms,60000), intdiv($ms%60000,1000), $ms%1000);
            echo '<tr' . ($position === 1 ? ' class="fastest"' : '') . '><td>' . $position . '</td><td>' . gt7h($row['player']) . '</td><td>' . gt7h($lap) . '</td></tr>';
        }
        echo '</tbody></table></div>';
    } else echo '<p class="empty-state">No lap times for this circuit yet.</p>';
    $stmt->close();
}
echo '</section><section class="recent-section"><h2>Latest 10 Circuit Experience Times</h2>';
$r = $conn->query('SELECT e.lap_time, e.player, t.track_name FROM gt7_entries e JOIN gt7_tracks t ON t.id=e.track_id ORDER BY e.id DESC LIMIT 10');
if ($r->num_rows) { echo '<div class="table-scroll"><table><thead><tr><th>Lap Time</th><th>Track</th><th>Player</th></tr></thead><tbody>';
while ($row = $r->fetch_assoc()) echo '<tr><td>' . gt7h($row['lap_time']) . '</td><td>' . gt7h($row['track_name']) . '</td><td>' . gt7h($row['player']) . '</td></tr>';
echo '</tbody></table></div>'; }
else echo '<p class="empty-state">No times recorded yet.</p>';
echo '</section>';
?>
