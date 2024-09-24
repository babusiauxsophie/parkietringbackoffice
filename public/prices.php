<?php

require_once 'app.php';
include_once "$dir/partial/header-prices.php";

session_start();

// Controleer of de gebruiker is ingelogd.
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    // Als de gebruiker niet is ingelogd, doorsturen naar de inlogpagina.
    header('Location: login.php'); // Stuur de gebruiker terug naar de loginpagina.
    exit; // Beëindig de uitvoering van het script.
}

if (!isset($_SESSION['user']) && $_SESSION['user'] != 'admin') {
    // Als de gebruiker niet is ingelogd als 'admin', stuur ze naar de index.php-pagina.
    header('Location: index.php'); // Stuur de gebruiker door naar de index.php-pagina.
    exit; // Beëindig de uitvoering van het script.
}
?>

<section class="wrapper">
<div class="header-breadcrumbs">
    <div>
        <a href="/index.php">Dashboard</a>
        <span>/</span>
        <a class="active-page" href="/prices.php">Prijzen</a>
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
    
    <div class="header-titles">
        <h1>Prijzen</h1>
    </div>

    <hr>

    <div class="data-container">
        <div class="data-list">

            <section class="tabel">
                <p class="tabel--name__small">Prijzen Verzending</p>
            </section>

            <ul class="data--card__list">
                    <li class="data--item">
                        <p class="data--item--price">Bpost</p>

                        <a href="/editshippingcosts.php" class="data--button data--button__icon">
                            <img src="/images/editsvg.svg" alt="edit">
                        </a>
                    </li>
                </ul>

            <section class="tabel">
                <p class="tabel--name__small">Prijzen Ringen</p>
            </section>

            <ul class="data--card__list">
                    <li class="data--item">
                        <p class="data--item--price">BLHA en INOX</p>

                        <a href="/rings.php" class="data--button data--button__icon">
                            <img src="/images/editsvg.svg" alt="edit">
                        </a>
                    </li>
            </ul>

        </div>
    </div>
</section>