<?php

$pageTitle = $pageTitle ?? 'Арифметическая прогрессия';
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
<div class="page">
    <header class="site-header">
        <div class="brand">
            <h1>Арифметическая прогрессия</h1>
            <p>Заполните пропущенное число и проверьте себя.</p>
        </div>
        <nav class="nav">
            <a href="/">Главная</a>
            <a href="/play.php">Играть</a>
            <a href="/history.php">История</a>
        </nav>
    </header>
    <main>
        <?php require $view; ?>
    </main>
    <footer class="footer">
        <span>SQLite сохраняет историю игр на этом компьютере.</span>
    </footer>
</div>
</body>
</html>
