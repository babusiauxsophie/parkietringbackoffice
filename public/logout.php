<?php
session_start(); // Start een PHP-sessie.

session_destroy(); // Vernietigt alle sessievariabelen en beëindigt de huidige sessie.

header('Location: login.php'); // Stuurt de gebruiker terug naar de loginpagina na het beëindigen van de sessie.