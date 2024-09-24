<?php

require_once 'app.php';
include_once "$dir/partial/header-orders.php";

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
            <a class="active-page" href="/orders.php">Bestellingen</a>
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
        <h1>Bestellingen</h1>

        <div class="searchbar">
            <form method="GET" action="/orders.php">
                <input type="text" name="search" id="search" class="form-control" placeholder=" 🔎 Zoeken..."
                    value="<?php echo isset($search) ? htmlentities($search) : ''; ?>">
            </form>
        </div>
    </div>

    <hr>



    <div class="data-container">
        <div class="data-list">

            <section class="tabel tabel--long">
                <p class="tabel--name__small">Betaald</p>
                <p class="tabel--name__small">Stamnummer</p>
                <p class="tabel--name__small">Adres</p>
                <p class="tabel--name__small tabel--name__middle tabel--name__middle--second">Gemeente</p>
                <p class="tabel--name__small table--name__small--second">Postcode</p>
                <p class="tabel--name__small table--name__small--third">Type</p>
            </section>

            <?php
            $search = isset($_GET['search']) ? $_GET['search'] : ''; // Retrieve the search parameter from the URL. If it doesn't exist, use an empty value.
            $orders = getOrders($search); // Pass the search parameter to the getMembers function.
            foreach ($orders as $order) {
                include "$dir/views/orders/orderitem.php"; // Loop through each order object and include the corresponding 'orderitem.php' display. This can be repeated for each member object in the list.
            }
            ?>
        </div>
    </div>