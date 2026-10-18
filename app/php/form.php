<form method="post" action="php/leaderboard.php">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8'); ?>">

    <label for="player">Player:</label>
    <input type="text" id="player" name="player" maxlength="80" required>

    <label for="minutes">Lap Time:</label>
    <div class="lap-time-input">
        <select id="minutes" name="minutes">
            <?php for ($i = 0; $i <= 9; $i++) { echo "<option value='$i'>$i min</option>"; } ?>
        </select>
        :
        <select name="seconds" aria-label="Seconds">
            <?php for ($i = 0; $i <= 59; $i++) { echo "<option value='$i'>$i sec</option>"; } ?>
        </select>
        .
        <input type="text" name="milliseconds" inputmode="numeric" pattern="[0-9]{1,3}" title="Enter milliseconds (0-999)" placeholder="000" required>
    </div>

    <label for="track">Track:</label>
    <select id="track" name="track" required>
        <option value="">Select a track</option>
        <?php
        $trackQuery = "SELECT DISTINCT race_name FROM calendar_2024 ORDER BY race_name";
        $trackResult = $conn->query($trackQuery);
        if ($trackResult && $trackResult->num_rows > 0) {
            while ($trackRow = $trackResult->fetch_assoc()) {
                $raceName = htmlspecialchars($trackRow['race_name'], ENT_QUOTES, 'UTF-8');
                echo "<option value=\"{$raceName}\">{$raceName}</option>";
            }
        } else {
            echo "<option value=''>No tracks found</option>";
        }
        ?>
    </select>

    <input type="submit" value="Enter Time to Leaderboard" class="submit-btn">
</form>
