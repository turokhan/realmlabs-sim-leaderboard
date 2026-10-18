<form method="post" action="php/gt7-leaderboard.php">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8'); ?>">

    <label for="gt7-player">Player:</label>
    <input type="text" id="gt7-player" name="player" maxlength="100" required>

    <label for="gt7-minutes">Lap Time:</label>
    <div class="lap-time-input">
        <select id="gt7-minutes" name="minutes">
            <?php for ($i = 0; $i <= 9; $i++) { echo "<option value='$i'>$i min</option>"; } ?>
        </select>
        :
        <select name="seconds" aria-label="Seconds">
            <?php for ($i = 0; $i <= 59; $i++) { echo "<option value='$i'>$i sec</option>"; } ?>
        </select>
        .
        <input type="text" name="milliseconds" inputmode="numeric" pattern="[0-9]{1,3}" title="Enter milliseconds (0-999)" placeholder="000" required>
    </div>

    <label for="gt7-track">Circuit Experience Track:</label>
    <select id="gt7-track" name="track_id" required>
        <option value="">Select a track</option>
        <?php
        $trackQuery = "SELECT id, track_name FROM gt7_tracks ORDER BY sort_order, track_name";
        $trackResult = $conn->query($trackQuery);
        if ($trackResult && $trackResult->num_rows > 0) {
            while ($trackRow = $trackResult->fetch_assoc()) {
                $trackId = (int)$trackRow['id'];
                $trackName = htmlspecialchars($trackRow['track_name'], ENT_QUOTES, 'UTF-8');
                echo "<option value=\"{$trackId}\">{$trackName}</option>";
            }
        } else {
            echo "<option value='' disabled>No GT7 tracks found</option>";
        }
        ?>
    </select>

    <input type="submit" value="Enter GT7 Time" class="submit-btn">
</form>
