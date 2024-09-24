<?php

require_once 'app.php';
include_once "$dir/partial/header.php";

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

<div class="dashboard-top">
    <div class="header-titles">
        <h1>Dashboard</h1>
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

    <hr>
    
    <div class="data-container data-container--dashboard">
        <div class="data-list">
            <h2 class="title-dashboard">Deze leden hebben hun lidgeld nog niet betaald</h2>

            <?php foreach (getUnpaidMembers() as $member): ?>
                <section class="tabel tabel--long tabel--long__grey">
                    <p class="tabel--name table--name__dashboard">
                        <?= $member->firstname ?? 'Niet gevonden' ?>
                        <?= $member->lastname ?? 'Niet gevonden' ?>
                    </p>
                    
                    <button class="button--lightgreen">
                        <a href="mailto:<?= $member->email ?? 'Niet gevonden' ?>">Email</a>
                    </button>
                </section>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="data-container data-container--dashboard">
        <div class="data-list">

        <h2 class="title-dashboard">Recente bestellingen</h2>

            <?php foreach (getRecentOrders() as $order): ?>
                <section class="tabel tabel--long tabel--long__grey">
                    <?php
                    // Controleer of de stamnumber_id bestaat in het $order object
                    if (property_exists($order, 'stamnumber_id')) {
                        // Haal de gegevens van de member op die bij deze order hoort
                        $memberData = getMemberData($order->stamnumber_id);
                        ?>
                        <p class="tabel--name table--name__dashboard">
                            <?= $memberData->firstname ?? 'Niet gevonden' ?>
                            <?= $memberData->lastname ?? 'Niet gevonden' ?>
                        </p>
                        <p class="date-time">
                            <?= $order->created_at ?>
                        </p>
                        <button class="button--lightblue">
                        <a href="/memberedit.php?id=<?= $order->stamnumber_id ?? ''; ?>">Bekijken</a>

                        </button>
                    <?php } else { ?>
                        <p class="tabel--name__small">
                            Lid-ID niet gevonden voor deze bestelling.
                        </p>
                    <?php } ?>
                </section>
            <?php endforeach; ?>
        </div>
    </div>
</section>