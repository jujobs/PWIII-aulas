<?php
// index.php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/Usuario.class.php';

// mensagens
$msg = '';
$msg_type = 'info';

// Registrar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'register') {
    // se você quiser permitir que o usuário informe um "id" externo, podes enviar; senão deixe em branco
    $external_id = isset($_POST['external_id']) && $_POST['external_id'] !== '' ? intval($_POST['external_id']) : null;
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    [$ok, $m] = registerUserPDO($external_id, $email, $senha);
    $msg = $m;
    $msg_type = $ok ? 'success' : 'error';
}

// Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'login') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    $u = authenticateUserPDO($email, $senha);
    if ($u) {
        // marcar sessão como "logado" (apenas demo)
        $_SESSION['logged_user_id'] = $u->getId();
        $msg = "Bem-vindo, " . htmlspecialchars($u->getEmail());
        $msg_type = 'success';
    } else {
        $msg = "Usuário ou senha inválidos.";
        $msg_type = 'error';
    }
}

// Logout simples
if (isset($_GET['logout'])) {
    unset($_SESSION['logged_user_id']);
    $msg = "Desconectado.";
    $msg_type = 'info';
}

// Excluir usuário (apenas teste via GET)
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    [$ok, $m] = deleteUserPDO((int)$_GET['delete']);
    $msg = $m;
    $msg_type = $ok ? 'success' : 'error';
}

// Dados para exibição
$users = getAllUsersPDO();
$loggedUser = null;
if (isset($_SESSION['logged_user_id'])) {
    // busca por id simples
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
      <!-- Formulário de cadastro -->
      <div class="card-inner">
        <h2>Cadastrar</h2>
        <form method="post">
          <input type="hidden" name="action" value="register">
          <label>ID (opcional)</label>
          <input name="external_id" type="number" placeholder="opcional">
          <label>Email</label>
          <input name="email" type="email" required>
          <label>Senha</label>
          <input name="senha" type="password" required>
          <button type="submit">Cadastrar</button>
        </form>
      </div>

      <!-- Formulário de login -->
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

    <hr>

    <h2>Usuários cadastrados</h2>
    <table>
      <thead>
        <tr><th>ID</th><th>external_id</th><th>Email</th><th>Criado</th><th>Ação</th></tr>
      </thead>
      <tbody>
        <?php foreach ($users as $u): ?>
          <tr>
            <td><?= $u->getId() ?? '-' ?></td>
            <td><?= $u->getExternalId() ?? '-' ?></td>
            <td><?= htmlspecialchars($u->getEmail()) ?></td>
            <td><!-- created_at não está no objeto; se quiser, busco a coluna no SQL -->-</td>
            <td><a href="?delete=<?= (int)$u->getId()?>" onclick="return confirm('Excluir usuário?')">Excluir</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <p class="foot">Observação: em produção proteja as rotas de exclusão/edição — aqui ficou aberto para facilitar testes locais.</p>
  </div>
</body>
</html>
