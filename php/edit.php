<?php
include("conexao.php");

// Verifica se o usuário está autenticado como administrador
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit;
}

// Verifica se o ID da reserva foi passado
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_reserva = $_GET['id'];

    // Busca os detalhes da reserva
    $sql = "SELECT * FROM reservas WHERE id = $id_reserva";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo '<script>alert("Reserva não encontrada."); window.location.href = "../admin.php";</script>';
        exit;
    }
} else {
    echo '<script>alert("ID de reserva inválido."); window.location.href = "../admin.php";</script>';
    exit;
}

// Atualiza a reserva no banco de dados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $checkin = mysqli_real_escape_string($conn, $_POST['checkin']);
    $checkout = mysqli_real_escape_string($conn, $_POST['checkout']);
    $quarto = mysqli_real_escape_string($conn, $_POST['quarto']);

    $sql_update = "UPDATE reservas SET nome='$nome', email='$email', checkin='$checkin', checkout='$checkout', quarto='$quarto' WHERE id=$id_reserva";

    if ($conn->query($sql_update) === TRUE) {
        echo '<script>alert("Reserva atualizada com sucesso."); window.location.href = "../admin.php";</script>';
    } else {
        echo '<script>alert("Erro ao atualizar reserva: ' . $conn->error . '");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reserva - Hotel Beu Mar</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Editar Reserva - Hotel Beu Mar</h1>
    </header>

    <main>
        <form method="post" action="edit.php?id=<?php echo $id_reserva; ?>">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $row['nome']; ?>" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
            <br>
            <label for="checkin">Check-in:</label>
            <input type="date" id="checkin" name="checkin" value="<?php echo $row['checkin']; ?>" required>
            <br>
            <label for="checkout">Check-out:</label>
            <input type="date" id="checkout" name="checkout" value="<?php echo $row['checkout']; ?>" required>
            <br>
            <label for="quarto">Tipo de Quarto:</label>
            <input type="text" id="quarto" name="quarto" value="<?php echo $row['quarto']; ?>" required>
            <br>
            <input type="submit" value="Salvar Alterações">
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Hotel Beu Mar. Todos os direitos reservados.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
