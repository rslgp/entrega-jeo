<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

$login = "admin";
$senha = "admin";
$nomeUsuario = $_POST['NickName'];
$senhaUsuario = $_POST['senha'];


if ($login === $nomeUsuario && $senha === $senhaUsuario) {

    session_start();
    $_SESSION['logado'] = 1;
    header('Location: src/pages/register.html');

} else {
    header('Location: index.html');    
}
?>