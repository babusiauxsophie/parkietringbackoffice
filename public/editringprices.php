<?php
require_once 'app.php'; // Inclusie van het 'app.php'-bestand voor vereiste functies en instellingen.

include_once "$dir/partial/header-prices.php"; // Inclusie van het 'header.php'-bestand voor de header van de pagina.

$id = $_GET['id'] ?? 0;
$ring = ($id) ? getRingById($id) : null;

if(count($_POST)) {
    $errors = [];
    
    $size = filter_input(INPUT_POST, 'size');

    $price = filter_input(INPUT_POST, 'price');

    $type = filter_input(INPUT_POST, 'type');

    if(count($errors) == 0) {
        if($id) {
            //update
            updateRing($id, $size, $price, $type);
        } else {
            //insert
            insertRing($size, $price, $type);
        }
        // redirect('/rings.php');
    }
} 

?>

<section class="wrapper">

    <div class="header-breadcrumbs">
        <div>  
            <a href="/index.php">Dashboard</a>
                <span>/</span>
                <a  href="/prices.php">Prijzen</a>
                <a  href="/rings.php">BLAH en INOX</a>
                <span>/</span>
            <a class="active-page" href="/editringprices.php"><?= $ring->type, ' ', $ring->size?></a>
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
            <a href="/prices.php">Terug naar overzicht</a>
    </button>

    <hr>

    <h1 class="header-titles top"><?= $ring->type, ' ', $ring->size?></h1>

    <div class="price-card">
    <form method="POST">
        <div class="form-group">
            <label class="price-title" for="size">Maat ring</label>
            <input type="text" name="size" id="size" class="form-control"
                value="<?= $_POST['size'] ?? $ring->size ?? '' ?>">
        </div>

        <div class="form-group">
            <label  for="price">Prijs ring</label>
            <input type="text" name="price" id="price" class="form-control"
                value="<?= $_POST['$price'] ?? $ring->price ?? '' ?>">
        </div>

        <div class="form-group form-group--select">
            <label class="price-title" for="type">Type ring</label>

            <select name="type" required>
                    <option value="">kies type ring</option>
                    <!-- Mapping van numerieke waarden naar tekstwaarden -->
                    <?php
                    $ringTypes = [
                        "BLAH" => "BLAH",
                        "INOX" => "INOX"
                        // Hier kunnen andere tekstwaarden en hun overeenkomstige numerieke waarden worden toegevoegd indien nodig
                    ];

                    // Itereren door de associatieve array om de opties voor het selectievak weer te geven
                    foreach ($ringTypes as $value => $text) {
                        // Controleren of de waarde overeenkomt met de geselecteerde waarde voor 'type' in $_POST of $ring->type
                        $selected = ($value == ($_POST['type'] ?? ($ring->type ?? ''))) ? 'selected' : '';

                        // Het genereren van een optie-element met de juiste waarde en tekst, en de 'selected' attribuut indien geselecteerd
                        echo "<option value='$value' $selected>$text</option>";
                    }
                    ?>
                </select>
        </div>


        <div class="form-group">
            <input type="hidden" name="id" value="<?= $id; ?>">
            <button class="save-btn save-btn--margin" type="submit" class="btn btn-primary">Bewerking opslaan</button>

        </div>

    </form>
    </div>



</section>