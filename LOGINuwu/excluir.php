<?php
require 'Usuario.class.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $usuario = new Usuario();
    $usuario->excluirUsuario($id); // método que você vai criar

    // Redireciona de volta para a lista
    header("Location: mostrar_registros.php");
    exit;
} else {
    echo "ID inválido.";
}
?>
