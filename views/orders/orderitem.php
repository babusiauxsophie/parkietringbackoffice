<?php
require_once 'app.php';

// Controleert of $order een object is
if (is_object($order)) {
    // Als $order een object is, haal de waarde van de eigenschap 'stamnumber_id' op
    $order_id = $order->order_id;

} else {
    // Als $order geen object is, druk een foutmelding af
    echo "Error: Invalid order object.";
}

if (is_object($order)) {
    // Als $order een object is, haal de waarde van de eigenschap 'stamnumber_id' op
    $stamnumber_id = $order->stamnumber_id;

    // Roep de getTotalprice-functie aan om de totale prijs te krijgen
    $totalPrice = getTotalprice($order->order_id);

    // Controleer of het resultaat geldig is voordat je het gebruikt
    if ($totalPrice === false) {
        // Handel de situatie af waarin er geen geldig resultaat is
        $totalPrice = "Niet beschikbaar";
    }

    // Roep de getTypeRingsFromOrder-functie aan om de ringtypes te krijgen
    $ringTypes = getTypeRings($order->order_id);

    // Controleer of het resultaat geldig is voordat je het gebruikt
    if ($ringTypes === false) {
        // Handel de situatie af waarin er geen geldig resultaat is
        $ringTypes = "Niet beschikbaar";
    }

} else {
    // Als $order geen object is, druk een foutmelding af
    echo "Error: Invalid order object.";
}

// delete order
if (isset($_POST['delete'])) {
    $id = $_POST['id']; // Haal de waarde van de 'id' op uit de POST-data

    if ($id) {
        deleteOrder($id); // Roep de functie aan om een order te verwijderen op basis van de 'id'.

        header('Location: /orders.php'); // Stuur de gebruiker door naar de prijzenpagina
        exit;
    }
}
?>

<ul class="data--card__list">
    <li class="data--item data--item--order">
        <div class="data--item__first data-item__first--order">

            <img src="/images/<?= $order->payed ? 'payed' : 'not-payed' ?>.svg"
                alt="<?= $order->payed ? 'Betaald' : 'Niet Betaald' ?>">

            <p class="data--id">
                <?= $order->stamnumber_id ?>
            </p>

            <p class="data--street">
                <?= $order->streetname ?>
                <?= $order->streetnumber ?>
            </p>

            <p class="data--city">
                <?= $order->town ?>
            </p>

            <p>
                <?= $order->zip ?>
            </p>

            <p class="type">
                <?php
                if (isset($ringTypes)) {
                    foreach ($ringTypes as $ring) {
                        echo $ring['type'] . '<br>';
                    }
                } else {
                    echo "Niet beschikbaar";
                }
                ?>
            </p>

        </div>

        <div class="button-container">
            <form class="button-wrapper" method="POST">
                <input type="hidden" name="id" value="<?= $order->order_id ?>">
                <button type="submit" name="delete" class="data--button data--button--red data--button__icon"
                    onclick="return confirm('Weet je zeker dat je deze bestelling wilt verwijderen?');">
                    <img src="/images/delete.svg" alt="delete">
                </button>
            </form>

            <a href="orderedit.php?id=<?= $order->order_id ?>" class="data--button data--button__icon">
                <img src="/images/editsvg.svg" alt="edit">
            </a>
        </div>
    </li>
</ul>