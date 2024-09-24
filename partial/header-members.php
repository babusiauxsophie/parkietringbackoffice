<?php

require_once 'app.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/navigation.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/tables.css">
    <link rel="stylesheet" href="/css/data.css">
    <link rel="stylesheet" href="/css/forms.css">
    <link rel="stylesheet" href="/css/buttons.css">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
</head>

<body>
    <main>
        <!-- moet nog dynamisch worden gemaakt eens databank is gekoppeld -->
        <section class="navigation">
            <img class="logo" src="/images/logo.png" alt="logo">

            <nav>
                <ul>
                    <li class="nav__item">
                        <a class="nav__link" href="/">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav__item nav__item--active">
                        <a class="nav__link" href="/members.php">
                            Leden
                        </a>
                    </li>
                    <li class="nav__item">
                        <a class="nav__link" href="/orders.php">
                            Bestellingen
                        </a>
                    </li>
                    <li class="nav__item">
                        <a class="nav__link" href="/prices.php">
                            Prijzen
                        </a>
                    </li>


                    <li class="nav__item nav__item--green">
                        <img src="/images/plus.svg" alt="plus">
                        <a class="nav__link" href="/addmember.php">

                            Nieuw Lid
                        </a>
                    </li>


                    <li class="nav__item">
                        <img class="avatar" src="/images/avatar.svg" alt="avatar"> 
                        <a class="nav__link" href="/profile.php">

                            Luc
                        </a>
                    </li>

                </ul>
            </nav>



        </section>
    </main>
</body>

</html>