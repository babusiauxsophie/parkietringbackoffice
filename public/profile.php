<?php
require_once 'app.php';
include_once "$dir/partial/header.php";

session_start();

// Check if the user is logged in.
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    // If the user is not logged in, redirect to the login page.
    header('Location: login.php'); // Redirect the user back to the login page.
    exit; // Terminate the script execution.
}

// Fetch user details from the session or database using the getUser function
if (isset($_SESSION['user']->user)) {
    $user = $_SESSION['user']->user;
} else {
    // If the 'user' property doesn't exist in the session, try to get the user from the database
    $user = getUser();

    if (!is_object($user) || empty($user->user_id)) {
        // If the user couldn't be retrieved from the database, display an error
        echo "Error: Unable to fetch user details.";
        exit;
    }
}

// Check if $user is an object with 'email' and 'password' properties
if (is_object($user) && property_exists($user, 'email') && property_exists($user, 'password')) {
    // If $user is an object, retrieve the values of the 'user_id', 'email', and 'password' properties
    $user_id = $user->user_id;
    $email = $user->email;
    $hashedPassword = $user->password;
} else {
    // If $user is not an object with the required properties, print an error message
    echo "Error: Invalid user object.";
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST["user_id"];
    $newEmail = $_POST["new_email"];
    $newPassword = $_POST["new_password"];

    try {
        $pdo = new PDO("mysql:host=db;dbname=db", "root", "root");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (!empty($newEmail)) {
            // If new email is provided, update email
            $newEmail = filter_var($newEmail, FILTER_VALIDATE_EMAIL);

            if ($newEmail !== false) {
                $stmt = $pdo->prepare("UPDATE db.users SET email = :new_email WHERE user_id = :user_id");
                $stmt->bindParam(":new_email", $newEmail, PDO::PARAM_STR);
                $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                echo "Error: Invalid email address.";
                exit;
            }
        }

        if (!empty($newPassword)) {
            // If new password is provided, update password
            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("UPDATE db.users SET password = :new_password WHERE user_id = :user_id");
            $stmt->bindParam(":new_password", $newPassword, PDO::PARAM_STR);
            $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
            $stmt->execute();
        }

        // Reload the page to display the updated values
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();

    } catch (PDOException $e) {
        // Log the error to a file or handle it appropriately
        error_log("Error updating email and password: " . $e->getMessage(), 0);
        echo "Error updating email and password: " . $e->getMessage();
    }
}
?>

<section class="wrapper">
    <div class="dashboard-top">
        <div class="header-titles">
            <h1>Profiel Luc</h1>
        </div>
        <div>
            <a href="/logout.php">
                <button class="logout-btn">
                    <img src="/images/logout.svg" alt="logout">
                    <p>Afmelden</p>
                </button>
            </a>
        </div>
    </div>
    <hr>
    <div class="member-card">
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="user_id" value="<?= $user_id ?>">
            <div class="form-group form-group--profile">
                <label for="email">Email</label>
                <input type="text" name="new_email" placeholder="New Email" id="newEmail"
                    value="<?= isset($newEmail) ? $newEmail : $email ?>">
            </div>
            <div class="form-group form-group--profile">
                <label for="password">Wachtwoord</label>
                <input type="password" name="new_password" placeholder="New Password"
                    value="<?= isset($newPassword) ? $newPassword : '' ?>">
            </div>
            <div class="form-group">
                <button class="save-btn save-btn--margin" type="submit" class="btn btn-primary">Bewerking
                    opslaan</button>
            </div>
        </form>
    </div>
</section>