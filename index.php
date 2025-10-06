<?php
$redis = new Redis();
$redis->connect('redis-master', 6379);

// Si hay un nuevo mensaje
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message']) && trim($_POST['message']) !== '') {
    $msg = htmlspecialchars($_POST['message']);
    $redis->lPush('guestbook', $msg);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Obtener mensajes
$messages = $redis->lRange('guestbook', 0, 19);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guestbook - Azure AKS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>📘 Guestbook</h1>
        <p>Aplicación Web Multi-Tier desplegada en <strong>Azure AKS</strong></p>

        <form method="POST" class="message-form">
            <input type="text" name="message" placeholder="Escribe tu mensaje..." required>
            <button type="submit">Enviar</button>
        </form>

        <h2>Mensajes recientes:</h2>
        <ul class="message-list">
            <?php foreach ($messages as $msg): ?>
                <li><?= $msg ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <footer>
        <p>Desarrollado por Ricardo Solano | Proyecto AKS Guestbook</p>
    </footer>
</body>
</html>