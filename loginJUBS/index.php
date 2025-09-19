<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/Usuario.class.php';

$msg = '';
$msg_type = 'info';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'register') {
    $external_id = isset($_POST['external_id']) && $_POST['external_id'] !== '' ? intval($_POST['external_id']) : null;
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    [$ok, $m] = registerUserPDO($external_id, $email, $senha);
    $msg = $m;
    $msg_type = $ok ? 'success' : 'error';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'login') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    $u = authenticateUserPDO($email, $senha);
    if ($u) {
        $_SESSION['logged_user_id'] = $u->getId();
        $msg = "Bem-vindo, " . htmlspecialchars($u->getEmail());
        $msg_type = 'success';
    } else {
        $msg = "Usuário ou senha inválidos.";
        $msg_type = 'error';
    }
}

if (isset($_GET['logout'])) {
    unset($_SESSION['logged_user_id']);
    $msg = "Desconectado.";
    $msg_type = 'info';
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    [$ok, $m] = deleteUserPDO((int)$_GET['delete']);
    $msg = $m;
    $msg_type = $ok ? 'success' : 'error';
}

$users = getAllUsersPDO();
$loggedUser = null;
if (isset($_SESSION['logged_user_id'])) {
    foreach ($users as $uu) {
        if ($uu->getId() === $_SESSION['logged_user_id']) {
            $loggedUser = $uu;
            break;
        }
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Sistema PDO - Usuários</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="card">
    <h1>Sistema de Usuários (PDO)</h1>

    <?php if ($msg): ?>
      <div class="status <?=htmlspecialchars($msg_type)?>"><?=htmlspecialchars($msg)?></div>
    <?php endif; ?>

    <div class="row">

      <div class="card-inner">
        <h2>Cadastrar</h2>
        <form method="post">
          <input type="hidden" name="action" value="register"> 
          <label>Email</label>
          <input name="email" type="email" required>
          <label>Senha</label>
          <input name="senha" type="password" required>
          <button type="submit">Cadastrar</button>
        </form>
      </div>

      <div class="card-inner">
        <h2>Login</h2>
        <?php if ($loggedUser): ?>
          <p>Logado como <strong><?=htmlspecialchars($loggedUser->getEmail())?></strong></p>
          <p><a href="?logout=1">Sair</a></p>
        <?php else: ?>
          <form method="post">
            <input type="hidden" name="action" value="login">
            <label>Email</label>
            <input name="email" type="email" required>
            <label>Senha</label>
            <input name="senha" type="password" required>
            <button type="submit">Entrar</button>
          </form>
        <?php endif; ?>
      </div>
    </div>

    <img class="imagenzinha" src="images/gatito.jpg" alt="">

  </div>
</body>
</html>
