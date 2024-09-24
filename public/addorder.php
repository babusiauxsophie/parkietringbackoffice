<?php
require_once 'app.php'; // Inclusie van het 'app.php'-bestand voor vereiste functies en instellingen.
include_once "$dir/partial/header-orders.php";

// $id = $_GET['id']; // De id van de te bewerken bestelling wordt opgehaald uit de URL.
// $order = ($id) ? getOrderById($id) : null; // Als er een id is meegegeven, wordt de functie getOrderById() uitgevoerd met het meegegeven id. Anders wordt $order op null gezet.

$members = getMembers();
$rings = getRings();
$prices = getPrices();

$errors = []; // Initialiseer een lege array om foutmeldingen op te slaan.

if (count($_POST)) {
    // Gebruiker heeft op submit geklikt.

    $errors = []; // Initialiseer de array voor foutmeldingen.

    // Validatie van ingediende gegevens
    $payed = isset($_POST['payed']) ? 1 : 0; // Haal 'payed' op
    $stamnumber_id = filter_input(INPUT_POST, 'stamnumber_id'); // Haal 'stamnumber_id' op
    $streetname = filter_input(INPUT_POST, 'streetname'); // Haal 'streetname' op
    $streetnumber = filter_input(INPUT_POST, 'streetnumber'); // Haal 'streetnumber' op
    $town = filter_input(INPUT_POST, 'town'); // Haal 'town' op
    $zip = filter_input(INPUT_POST, 'zip'); // Haal 'zip' op
    $order_id = filter_input(INPUT_POST, 'order_id');
    $ring_id = filter_input(INPUT_POST, 'ring_id');
    $quantity = filter_input(INPUT_POST, 'quantity');
    $price = filter_input(INPUT_POST, 'price');

    if (count($errors) == 0) {
        // Call the function to update the price
        updateRingTotalPrice($order_id, $ring_id, $price, $quantity);

        // Call the function to update the ring quantity
        updateRingQuantity($order_id, $ring_id, $quantity);

        // Insert the order into the database
        insertOrder($payed, $stamnumber_id, $streetname, $streetnumber, $town, $zip, $ring_id, $_POST['postalparcel_id']);

        header('Location: orders.php');
        exit;
    } else {
        $errors[] = 'Vul alle verplichte velden in.';
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
            <a class="active-page" href="#">Nieuwe Bestelling</a>
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

    <h1 class="header-titles top">Nieuwe Bestelling</h1>

    <form class="order-card" method="POST">

        <input type="hidden" name="order_id" value="<?= $order_id ?? '' ?>">
        
        <div class="form-group form-group--radio">
            <label>Betaling</label>

            <label for="payed">
                <input type="radio" name="payment_status" id="payed" value="1" <?php echo isset($_POST['payment_status']) && $_POST['payment_status'] == 1 ? 'checked' : ''; ?>>
                Betaald
            </label>

            <label for="not_payed">
                <input type="radio" name="payment_status" id="not_payed" value="0" <?php echo isset($_POST['payment_status']) && $_POST['payment_status'] == 0 ? 'checked' : ''; ?>>
                Niet Betaald
            </label>

            <?php if (isset($order)): ?>
                <?php if ($order->payed): ?>
                    <img src="/images/payed.svg" alt="Betaald">
                <?php else: ?>
                    <img src="/images/not-paid.svg" alt="Niet Betaald">
                <?php endif; ?>
            <?php endif; ?>
        </div>


        <div class="form-group form-group--select">
            <label for="stamnumber_id">Lid selecteren</label>
            <select name="stamnumber_id" id="stamnumber_id" required class="select-member">
                <option value="">Selecteer een lid</option>
                <?php foreach ($members as $member): ?>
                    <option value="<?= $member->stamnumber_id; ?>">
                        <?= $member->stamnumber_id . ' - ' . $member->firstname . ' ' . $member->lastname; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="streetname">Straatnaam</label>
            <input type="text" name="streetname" id="streetname" value="<?= $order->streetname ?? '' ?>">
        </div>

        <div class="form-group">
            <label for="streetnumber">Straatnummer</label>
            <input type="text" name="streetnumber" id="streetnumber" value="<?= $order->streetnumber ?? '' ?>">
        </div>

        <div class="form-group">
            <label for="town">Gemeente</label>
            <input type="text" name="town" id="town" value="<?= $order->town ?? '' ?>">
        </div>

        <div class="form-group form-group--small">
            <label for="zip">Postcode</label>
            <input type="text" name="zip" id="zip" value="<?= $order->zip ?? '' ?>">
        </div>
        

        <div class="order-flex">

            <div class="order-flex--item">
                <label for="quantity">Aantal ringen</label>
                <input type="text" name="quantity" id="quantity" value="<?= $order_ring['quantity'] ?? '' ?>">
            </div>

            <div class="form-group--select ">
                <label for="ring_id">Selecteer een ringmaat</label>
                <select name="ring_id" required>
                    <option value="">Selecteer een ringmaat</option>
                    <?php foreach ($rings as $ring): ?>
                        <option value="<?= $ring->ring_id; ?>">
                            <?= $ring->size . ' - ' . $ring->price; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group--select form-group--select__middle">
                <label for="ring_id">Selecteer het type van de ring</label>
                <select name="ring_id" required>
                    <option value="">Selecteer een type</option>
                    <?php
                    $uniqueTypes = array(); // Array om unieke types bij te houden
                    
                    foreach ($rings as $ring):
                        // Controleer of het type al in de array zit
                        if (!in_array($ring->type, $uniqueTypes)):
                            $uniqueTypes[] = $ring->type; // Voeg het type toe aan de unieke array
                            ?>
                            <option value="<?= $ring->ring_id; ?>">
                                <?= $ring->type; ?>
                            </option>
                            <?php
                        endif;
                    endforeach;
                    ?>
                </select>
            </div>

        </div>

        <div class="order-flex--item">
                <label for="price">prijs</label>
                <input type="text" name="price" id="price" value="<?= $order_ring['price'] ?? '' ?>">
        </div>

        <div class="form-group--select form-group--select--large">
            <label for="postalparcel_id">Selecteer een mogelijkheid voor verzending</label>
            <select name="postalparcel_id" required>
                <option value="">Selecteer een verzending</option>
                <?php foreach ($prices as $price): ?>
                    <option value="<?= $price->postalparcel_id; ?>">
                        <?= $price->type; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <input type="hidden" name="id" value="<?= $id; ?>">
            <button class="save-btn save-btn--margin" type="submit" class="btn btn-primary">Bewerking opslaan</button>
        </div>
    </form>
</section>