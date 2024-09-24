<?php
require_once 'app.php'; // Inclusie van het 'app.php'-bestand voor vereiste functies en instellingen.
include_once "$dir/partial/header-members.php";

// $id = $_GET['id']; // De id van de te bewerken gebruiker wordt opgehaald uit de URL.
// $member = ($id) ? getMemberById($id) : null; // Als er een id is meegegeven, wordt de functie getMemberById() uitgevoerd met het meegegeven id. Anders wordt $member op null gezet.

$errors = []; // Initialiseer een lege array om foutmeldingen op te slaan.

if (count($_POST)) {
    // Gebruiker heeft op submit geklikt.

    $errors = []; // Initialiseer de array voor foutmeldingen.

    // Validatie van ingediende gegevens
    $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$firstname) {
        $errors[] = 'Voornaam is verplicht.';
    }

    if (!$lastname) {
        $errors[] = 'Achternaam is verplicht.';
    }

    $email = filter_input(INPUT_POST, 'email');
    $streetname = filter_input(INPUT_POST, 'streetname');
    $streetnumber = filter_input(INPUT_POST, 'streetnumber');
    $town = filter_input(INPUT_POST, 'town');
    $zip = filter_input(INPUT_POST, 'zip');
    $telephonenumber = filter_input(INPUT_POST, 'telephonenumber');
    $payed = filter_input(INPUT_POST, 'payed');

    if (count($errors) == 0) {
        // Er zijn geen fouten gevonden, dus de gebruiker kan worden toegevoegd.

        $stamnumber_id = generateUniqueStamnummer(); // Genereer een uniek stamnummer

        // Assuming $stamnumber_id is defined somewhere in your code
        insertMember($firstname, $lastname, $email, $streetname, $streetnumber, $town, $zip, $telephonenumber, $payed);

        // Redirect the user to the ledenlijst after insertion
        header('Location: members.php');
        exit;
    }
}

?>

<section class="wrapper">

    <div class="header-breadcrumbs">
        <div>
            <a href="/index.php">Dashboard</a>
            <span>/</span>
            <a href="/members.php">Leden</a>
            <span>/</span>
            <a class="active-page" href="#">Lid Toevoegen</a>
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
        <a href="/members.php">Terug naar overzicht</a>
    </button>

    <hr>

    <h1 class="header-titles top">Lid Toevoegen</h1>

    <form class="member-card" method="POST">

    <div class="member-flex">

        <div class="member-flex--item">
                <div class="form-group">
                    <label for="firstname">Voornaam</label>
                    <input type="text" name="firstname" id="firstname" class="form-control"
                        value="<?= $_POST['firstname'] ?? $member->firstname ?? '' ?>">
                </div>

                <div class="form-group">
                    <label for="lastname">Achternaam</label>
                    <input type="text" name="lastname" id="lastname" class="form-control"
                        value="<?= $_POST['$lastname'] ?? $member->lastname ?? '' ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control"
                        value="<?= $_POST['email'] ?? $member->email ?? '' ?>">
                </div>

                <div class="form-group">
                    <label for="streetname">Straatnaam</label>
                    <input type="text" name="streetname" id="streetname" class="form-control"
                        value="<?= $_POST['streetname'] ?? $member->streetname ?? '' ?>">
                </div>

                <div class="form-group form-group--small">
                    <label for="streetnumber">Straatnummer</label>
                    <input type="text" name="streetnumber" id="streetnumber" class="form-control"
                        value="<?= $_POST['streetnumber'] ?? $member->streetnumber ?? '' ?>">
                </div>

                <div class="form-group">
                    <label for="town">Gemeente</label>
                    <input type="text" name="town" id="town" class="form-control"
                        value="<?= $_POST['town'] ?? $member->town ?? '' ?>">
                </div>

                <div class="form-group form-group--small">
                    <label for="zip">Postcode</label>
                    <input type="text" name="zip" id="zip" class="form-control"
                        value="<?= $_POST['zip'] ?? $member->zip ?? '' ?>">
                </div>

                <div class="form-group form-group--small">
                    <label for="telephonenumber">Telefoonnummer</label>
                    <input type="text" name="telephonenumber" id="telephonenumber" class="form-control"
                        value="<?= $_POST['telephonenumber'] ?? $member->telephonenumber ?? '' ?>">
                </div>

                <div class="form-group">
                    <input type="hidden" name="id" value="<?= $id; ?>">
                    <button class="save-btn save-btn--margin" type="submit" class="btn btn-primary">Bewerking opslaan</button>
                </div>
        </div>

            <div class="form-group form-group--radio">
                <label for="payed">Lidgeld betaald</label>
                    <div class="form-check">
                        <input type="radio" name="payed" id="payed-true" class="form-check-input"
                            value="true" <?= (isset($_POST['payed']) && $_POST['payed'] == 'true') || (isset($member->payed) && $member->payed == 'true') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="payed-true">Ja</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="payed" id="payed-false" class="form-check-input"
                            value="false" <?= (isset($_POST['payed']) && $_POST['payed'] == 'false') || (isset($member->payed) && $member->payed == 'false') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="payed-false">Nee</label>
                    </div>
            </div>

    </div>

    </form>

</section>