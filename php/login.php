<?php
session_start();
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha= mysqli_real_escape_string($conn, $_POST['senha']);

    $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['admin'] = true;
        header("Location: ../admin.php");
    } else {
        $error_message = "Credenciais inválidas. Por favor, tente novamente.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hotel Beu Mar</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            width: 300px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
        }

        .login-container form label {
            margin-bottom: 8px;
        }

        .login-container form input[type="email"],
        .login-container form input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-container form input[type="submit"] {
            padding: 10px;
            background-color: #ca6b34;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .login-container form input[type="submit"]:hover {
            background-color: #e68642;
        }

        .error-message {
            color: #f44336;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Administração - Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Usuário:</label>
            <input type="email" id="username" name="email" required>

            <label for="password">Senha:</label>
            <input type="password" id="password" name="senha" required>

            <input type="submit" value="Entrar">
        </form>

        <?php
        if (isset($error_message)) {
            echo '<p class="error-message">' . $error_message . '</p>';
        }
        ?>
    </div>
</body>
</html>
