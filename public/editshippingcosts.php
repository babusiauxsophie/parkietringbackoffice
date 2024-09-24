<?php
require_once 'app.php'; // Inclusie van het 'app.php'-bestand voor vereiste functies en instellingen.

include_once "$dir/partial/header-prices.php"; // Inclusie van het 'header.php'-bestand voor de header van de pagina.

?>

<section class="wrapper">

    <div class="header-breadcrumbs">
        <div>
            <a href="/index.php">Dashboard</a>
            <span>/</span>
            <a  href="/prices.php">Prijzen</a>
            <span>/</span>
            <a class="active-page" href="/editshippingcosts.php">Bpost</a>
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

    <h1 class="header-titles top">Prijzen Bpost</h1>

    <div class="price-card">
        <?php
        $prices = getPrices();
        foreach ($prices as $price) {
            include "$dir/views/prices/priceitem.php";
        }
        ?>
        <button class="save-btn">
            Prijs Opslaan
        </button>
    </div>

</section>