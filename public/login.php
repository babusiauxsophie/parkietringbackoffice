<?php
require_once 'app.php'; // Inclusion of the 'app.php' file for required functions and settings.

session_start(); // Start a PHP session to track session data.

$correct_pass_hash = '$2y$10$6klENqbValTQ6cAg8yNjHerPqNbJTZx7oF8NUlgLoI8/ngnWc94pq'; // The hashed expected password.

// Establish a database connection
try {
    $pdo = new PDO("mysql:host=db;dbname=db", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Log the error to a file or handle it appropriately
    error_log("Database connection error: " . $e->getMessage(), 0);
    echo "Database connection error: " . $e->getMessage();
    exit;
}

$login = $_POST['login'] ?? ''; // Retrieve the submitted email address or set it to an empty string if not provided.
$password = $_POST['password'] ?? ''; // Retrieve the submitted password or set it to an empty string if not provided.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = isset($_POST['login']) ? $_POST['login'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($login && $password) {
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            // Fetch user details from the database based on the email
            $stmt = $pdo->prepare("SELECT * FROM db.users WHERE email = :email");
            $stmt->bindParam(":email", $login, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);

            // Check if the user exists and the entered password is correct
            if ($user && password_verify($password, $user->password)) {
                $_SESSION['user'] = $login;
                header('Location: index.php');
                exit;
            } else {
                $_SESSION['user'] = null;
                $error_message = 'Incorrect username or password.';
            }
        }
    }
}

$user = $_SESSION['user'] ?? ''; // Set $user to the value of $_SESSION['user'] if it exists, otherwise, initialize it to an empty string.
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

</head>

<body>

    <section class="login-container">
        <div class="login-container-left">

        </div>

        <div class="auth-container">

            <div class="logo-container">
                <img class="logo" src="/images/logo.png" alt="logo">
                <div>
                    <h4>Welkom Luc!</h4>
                    <p>beheer hier je leden<br>en bestellingen</p>
                </div>

            </div>

            <div class="auth-container__login">
                <form method="POST">
                    <div class="email-login">
                        <label for="login">Email</label>
                        <div class="email__box">
                            <input type="text" name="login" id="login">
                        </div>
                    </div>
                    <div class="email-login">
                        <label for="password">Wachtwoord</label>
                        <div class="email__box">
                            <input type="password" name="password" id="password">
                        </div>
                    </div>
                    <button class="login-submit-btn" type="submit">Inloggen</button>
                </form>
            </div>
        </div>




        </div>
    </section>

</body>

</html>