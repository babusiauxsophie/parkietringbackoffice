<?php
require_once 'app.php'; // Inclusie van het 'app.php'-bestand voor vereiste functies en instellingen.
include_once "$dir/partial/header-orders.php";

$id = $_GET['id']; // De id van de te bewerken bestelling wordt opgehaald uit de URL.
$order = ($id) ? getOrderById($id) : null; // Als er een id is meegegeven, wordt de functie getOrderById() uitgevoerd met het meegegeven id. Anders wordt $order op null gezet.

$errors = []; // Initialiseer een lege array om foutmeldingen op te slaan.

if (count($_POST)) {
    // Gebruiker heeft op submit geklikt.

    $errors = []; // Initialiseer de array voor foutmeldingen.

    // Validatie van ingediende gegevens
    $payed = filter_input(INPUT_POST, 'payed') ? 1 : 0; // Haal 'payed' op
    $stamnumber_id = filter_input(INPUT_POST, 'stamnumber_id');
    $streetname = filter_input(INPUT_POST, 'streetname'); // Haal 'streetname' op
    $streetnumber = filter_input(INPUT_POST, 'streetnumber'); // Haal 'streetnumber' op
    $town = filter_input(INPUT_POST, 'town'); // Haal 'town' op
    $zip = filter_input(INPUT_POST, 'zip'); // Haal 'zip' op

    if (count($errors) == 0) {
        // Er zijn geen fouten gevonden, dus de gebruiker kan worden toegevoegd of bijgewerkt.

        if ($id) {
            // Er is een id meegegeven, dus de gebruiker moet worden bijgewerkt.
            updateOrder($id, $payed, $streetname, $streetnumber, $town, $zip);
        } else {
            // Er is geen id meegegeven, dus de gebruiker moet worden toegevoegd.
            insertOrder($payed, $stamnumber_id, $streetname, $streetnumber, $town, $zip, $ring_id, $_POST['postalparcel_id']);
        }

        header('Location: orders.php'); // Stuur de gebruiker door naar de bestellingenlijst.
        exit;
    }
}
?>

<section class="wrapper">

    <div class="header-breadcrumbs">
        <div>
            <a href="/index.php">Dashboard</a>
            <span>/</span>
            <a href="/orders.php">Bestellingen</a>
            <span>/</span>
            <a class="active-page" href="#">Bestelling bewerken</a>
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

    <button class="return-btn">
        <img src="/images/arrowside.svg" alt="arrow">
        <a href="/orders.php">Terug naar overzicht</a>
    </button>

    <hr>

    <h1 class="header-titles top">Bestelling bewerken</h1>

    <form class="order-card" method="POST">

        <div class="form-group form-group--radio">
            <label for="payed">Betaald</label>
            <label><input type="radio" name="payed" value="1" <?= ($order && $order->payed == 1) ? 'checked' : '' ?>> Ja</label>
            <label><input type="radio" name="payed" value="0" <?= ($order && $order->payed == 0) ? 'checked' : '' ?>> Nee</label>
        </div>

        <div class="form-group form-group--small">
            <label for="stamnumber_id">Stamnummer</label>
            <div class="no-edit" id="stamnumber_id"><?= $order->stamnumber_id ?? '' ?></div>
        </div>



        <div class="form-group">
            <label for="streetname">Straatnaam</label>
            <input type="text" name="streetname" id="streetname" value="<?= $order->streetname ?>">
        </div>

        <div class="form-group">
            <label for="streetnumber">Straatnummer</label>
            <input type="text" name="streetnumber" id="streetnumber" value="<?= $order->streetnumber ?>">
        </div>

        <div class="form-group">
            <label for="town">Gemeente</label>
            <input type="text" name="town" id="town" value="<?= $order->town ?>">
        </div>

        <div class="form-group form-group--small">
            <label for="zip">Postcode</label>
            <input type="text" name="zip" id="zip" value="<?= $order->zip ?>">
        </div>

        <div class="form-group">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <button class="save-btn save-btn--margin" type="submit" class="btn btn-primary">Bewerking opslaan</button>
        </div>
    </form>
</section>