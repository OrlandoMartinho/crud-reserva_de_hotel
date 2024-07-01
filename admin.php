<?php
include("php/conexao.php");

// Verifica se o usuário está autenticado como administrador (exemplo básico, adapte conforme necessário)
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: php/login.php"); // Redireciona para a página de login se não estiver autenticado
    exit;
}

// Processo para eliminar uma reserva
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id_reserva = $_GET['delete'];
    $sql_delete = "DELETE FROM reservas WHERE id = $id_reserva";
    if ($conn->query($sql_delete) === TRUE) {
        echo '<script>alert("Reserva eliminada com sucesso.");</script>';
    } else {
        echo '<script>alert("Erro ao eliminar reserva: ' . $conn->error . '");</script>';
    }
}

// Processo de busca de reservas
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $sql_search = "SELECT * FROM reservas WHERE nome ='$search' OR email = '$search' OR id = '$search'";
} else {
    $sql_search = "SELECT * FROM reservas";
}

$result = $conn->query($sql_search);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração - Hotel Beu Mar</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .search-form {
            margin-top:10vh ;
            margin-bottom: 20px;
        }

        .search-form input[type="text"] {
            padding: 8px;
            width: 250px;
        }

        .search-form input[type="submit"] {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .search-form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .btn-delete {
            padding: 6px 10px;
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            border-radius: 4px;
        }

        .btn-delete:hover {
            background-color: #da190b;
        }
        .btn-edit {
            padding: 6px 10px;
            background-color: #2196F3;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            border-radius: 4px;
        }

        .btn-edit:hover {
            background-color: #0b7dda;
        }

    </style>
</head>
<body>
    <header>
        <h1>Painel de Administração - Hotel Beu Mar</h1>
        <nav>
            <ul>
                <li><a href="#">Lista de Reservas</a></li>
                <li><a href="php/logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="search-form">
            <form method="post" action="admin.php">
               
                <input type="text" id="search" name="search" placeholder="Pesquisar por ID,Nome, Email ou Tipo de Quarto">
                <input type="submit" value="Buscar">
            </form>
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Tipo de Quarto</th>
                <th>Ações</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nome'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['checkin'] . "</td>";
                    echo "<td>" . $row['checkout'] . "</td>";
                    echo "<td>" . $row['quarto'] . "</td>";
                    echo '<td><a href="admin.php?delete=' . $row['id'] . '" class="btn-delete">Eliminar</a> <a href="php/edit.php?id=' . $row['id'] . '" class="btn-edit">Editar</a></td> ';
                   
                    echo "</tr>";
                }
            } else {
                echo '<tr><td colspan="7">Nenhuma reserva encontrada.</td></tr>';
            }
            ?>
        </table>
    </main>

    <footer>
        <p>&copy; 2024 Hotel Beu Mar. Todos os direitos reservados.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
