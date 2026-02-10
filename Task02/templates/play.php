<section class="game">
    <div class="game-card">
        <h2>Раунд</h2>
        <p class="progression"><?= htmlspecialchars($round['shown_progression']) ?></p>
        <?php if ($errors !== []): ?>
            <div class="notice error">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if ($result !== null): ?>
            <div class="notice <?= $result['is_win'] ? 'success' : 'error' ?>">
                <?php if ($result['is_win']): ?>
                    <p>Верно! Пропущенное число — <?= htmlspecialchars((string) $result['missing_value']) ?>.</p>
                <?php else: ?>
                    <p>Неверно. Правильная прогрессия:</p>
                    <p class="progression small"><?= htmlspecialchars($result['full_progression']) ?></p>
                    <p>Пропущенное число — <?= htmlspecialchars((string) $result['missing_value']) ?>.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if ($showNextLink): ?>
            <div class="actions">
                <a class="button" href="/play.php">Следующий раунд</a>
            </div>
        <?php endif; ?>
        <form class="form" method="post" action="/play.php">
            <label>
                Имя игрока
                <input type="text" name="player_name" value="<?= htmlspecialchars($playerName) ?>" placeholder="Игрок">
            </label>
            <label>
                Ваш ответ
                <input type="number" name="answer" value="" required>
            </label>
            <input type="hidden" name="shown_progression" value="<?= htmlspecialchars($round['shown_progression']) ?>">
            <input type="hidden" name="full_progression" value="<?= htmlspecialchars($round['full_progression']) ?>">
            <input type="hidden" name="missing_value" value="<?= htmlspecialchars((string) $round['missing_value']) ?>">
            <button class="button" type="submit">Проверить</button>
        </form>
    </div>
    <aside class="game-side">
        <h3>Советы</h3>
        <p>Разность прогрессии постоянна. Сравните соседние числа.</p>
        <p>Историю можно посмотреть в отдельном разделе.</p>
        <a class="button button-ghost" href="/history.php">Перейти к истории</a>
    </aside>
</section>
