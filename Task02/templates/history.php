<section class="history">
    <div class="history-card">
        <h2>История игр</h2>
        <?php if ($rows === []): ?>
            <p>Пока нет сыгранных игр. Сыграйте первую!</p>
        <?php else: ?>
            <div class="table">
                <div class="table-row table-head">
                    <span>Дата</span>
                    <span>Игрок</span>
                    <span>Результат</span>
                    <span>Прогрессия</span>
                    <span>Ответ</span>
                </div>
                <?php foreach ($rows as $row): ?>
                    <div class="table-row">
                        <span><?= htmlspecialchars((string) $row['played_at']) ?></span>
                        <span><?= htmlspecialchars((string) $row['player_name']) ?></span>
                        <span><?= ((int) $row['is_win'] === 1) ? 'победа' : 'ошибка' ?></span>
                        <span class="mono"><?= htmlspecialchars((string) $row['shown_progression']) ?></span>
                        <span><?= htmlspecialchars((string) $row['missing_value']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
