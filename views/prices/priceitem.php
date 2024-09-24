<?php
require_once 'app.php';

// Controleert of $price een object is
if (is_object($price)) {
    // Als $price een object is, haal de waarde van de eigenschap 'postalparcel_id' op
    $postalparcel_id = $price->postalparcel_id;
} else {
    // Als $price geen object is, druk een foutmelding af
    echo "Error: Invalid price object.";
}

// Controleer of het formulier is verzonden
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["postalparcel_id"]) && isset($_POST["new_price"])) {
    $postalparcelId = $_POST["postalparcel_id"];
    $newPrice = $_POST["new_price"];

    try {
        $pdo = new PDO("mysql:host=db;dbname=db", "root", "root");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("UPDATE db.postalparcels SET price = :new_price WHERE postalparcel_id = :postalparcel_id");
        $stmt->bindParam(":new_price", $newPrice, PDO::PARAM_STR);
        $stmt->bindParam(":postalparcel_id", $postalparcelId, PDO::PARAM_INT);
        $stmt->execute();

        // Laad de pagina opnieuw om de bijgewerkte waarde te tonen
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();

    } catch (PDOException $e) {
        // Log the error to a file or handle it appropriately
        error_log("Error updating price: " . $e->getMessage(), 0);
        echo "Error updating price: " . $e->getMessage();
    }
}

?>

<div class="price">
    <p class="price-title">
        <?= $price->type ?>
    </p>

    <form class="price-input" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input class="price-input" type="text" name="new_price" id="newPrice" value="<?= isset($newPrice) ? $newPrice : $price->price ?>">
        <input type="hidden" name="postalparcel_id" value="<?= $postalparcel_id ?>">  
    </form>
    
</div>
