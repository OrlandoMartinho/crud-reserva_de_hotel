<?php
include("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $checkin = mysqli_real_escape_string($conn, $_POST['checkin']);
    $checkout = mysqli_real_escape_string($conn, $_POST['checkout']);
    $quarto = mysqli_real_escape_string($conn, $_POST['quarto']);

    $sql = "INSERT INTO reservas (nome, email, checkin, checkout, quarto)
            VALUES ('$nome', '$email', '$checkin', '$checkout', '$quarto')";
    if ($conn->query($sql) === TRUE) {
        echo "Reserva realizada com sucesso!";
    } else {
        echo "Erro ao realizar a reserva: " . $conn->error;
    }
} else {
    echo "Método HTTP inválido.";
}

$conn->close();
?>