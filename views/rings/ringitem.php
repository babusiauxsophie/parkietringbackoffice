<?php
require_once 'app.php'; // Inclusie van het 'app.php'-bestand voor vereiste functies en instellingen.

// Controleert of $ring een object is
if (is_object($ring)) {
    // Als $ring een object is, haal de waarde van de eigenschap 'ring_id' op
    $ring_id = $ring->ring_id;
} else {
    // Als $ring geen object is, druk een foutmelding af
    echo "Error: Invalid ring object.";
}

// delete ring
if (isset($_POST['delete'])) {
    $id = $_POST['id']; // Haal de waarde van de 'id' op uit de POST-data

    if ($id) {
        deleteRing($id); // Roep de functie aan om een ring te verwijderen op basis van de 'id'.

        header('Location: /rings.php'); // Stuur de gebruiker door naar de prijzenpagina
        exit;
    }
}
?>

<ul class="data--card__list">
    <li class="data--item data--item--small">
        <div class="data--item__first">
            <p class="data--ring">
                <?= $ring->size ?>
            </p>

            <p class="data--ring">
                <?= $ring->price ?>
            </p>

            <p class="data--ring">
                <?= $ring->type ?>
            </p>
        </div>


        <div class="button-container">
            <form class="button-wrapper" method="POST">
                <input type="hidden" name="id" value="<?= $ring->ring_id ?>">
                <button type="submit" name="delete" class="data--button data--button--red data--button__icon"
                    onclick="return confirm('Weet je zeker dat je deze ring wilt verwijderen?');">
                    <img src="/images/delete.svg" alt="delete">
                </button>
            </form>

            <a href="editringprices.php?id=<?= $ring->ring_id ?>" class="data--button data--button__icon">
                <img src="/images/editsvg.svg" alt="edit">
            </a>
        </div>
    </li>
</ul>