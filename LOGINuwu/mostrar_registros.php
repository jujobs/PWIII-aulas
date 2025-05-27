<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/tabela.css">
    <title>Registros</title>
</head>
<body>
<?php

require 'Usuario.class.php';
$usuario = new Usuario();

if (!$usuario) {
    echo "<script>confirm('Banco indisponível. Tente novamente mais tarde!')</script>";
    return false;
} else {
    $dados = $usuario->getUsuarios();

    $table = "<div class='container mt-4'>";
    $table .= "<table class='table table-striped table-hover'>";
    $table .=   '<thead>';
    $table .=       "<h1 class='text'>Usuários Cadastrados</h1>";
    $table .=       '<tr>';
    $table .=           '<th>Selecionar Usuário</th>';
    $table .=           '<th>idUsuario</th>';
    $table .=           '<th>Nome</th>';
    $table .=           '<th>Email</th>';
    $table .=           '<th>Ações</th>';
    $table .=       '</tr>';
    $table .=   '</thead>';
    $table .=   '<tbody>';

    foreach ($dados as $item) {
        $id     = $item['id'];
        $name   = $item['nome'];
        $email  = $item['email'];

        $table .= "<tr>";
        $table .= "<td><input type='checkbox' value='$id'></td>";
        $table .= "<td>$id</td>";
        $table .= "<td>$name</td>";
        $table .= "<td>$email</td>";
        $table .= "<td>
            <a class='btn btn-danger btn-sm' href='excluir.php?id=$id'>Excluir</a>
            <a class='btn btn-primary btn-sm' href='editar.php?id=$id'>Editar</a>
           </td>";
        $table .= "</tr>";
    }

    $table .=   '</tbody></table>';
    $table .= "</div>";

    echo $table;
}
?>
</body>
</html>
