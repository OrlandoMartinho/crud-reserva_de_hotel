<?php
session_start();

// Verifica se a sessão do admin está definida
if (isset($_SESSION['admin'])) {
    // Remove todas as variáveis de sessão
    session_unset();

    // Destrói a sessão
    session_destroy();

    // Redireciona para a página de login
    header("Location: login.php");
    exit;
} else {
    // Se não houver sessão de admin definida, redireciona para o login
    header("Location: login.php");
    exit;
}
?>
