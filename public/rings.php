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
            <a  href="/prices.php">Prijzen</a>
            <span>/</span>
            <a class="active-page" href="#">BLAH en INOX</a>
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
    
    <div class="header-titles header-titles--search">
        <button class="return-btn">
            <img src="/images/arrowside.svg" alt="arrow">
            <a href="/prices.php">Terug naar overzicht</a>
        </button>

        <div class="searchbar">
            <form method="GET" action="/rings.php">
                <input type="text" name="search" id="search" class="form-control" placeholder=" 🔎 Zoeken..."
                value="<?php echo isset($search) ? htmlentities($search) : ''; ?>">
                </form>
        </div>
    </div>
    

    <hr>


    <h1 class="header-titles top">Prijzen BLAH Ringen</h1>
    <div class="data-container">
        <div class="data-list">
            <section class="tabel">
            <p class="tabel--name__small">Maat</p>
            <p class="tabel--name__small">Prijs</p>
            <p class="tabel--name__small">Type</p>
            </section>
        </div>

    </div>

    <?php
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $rings = getRings($search); 
    foreach ($rings as $ring) {
        include "$dir/views/rings/ringitem.php";
    }
    ?>
</section>