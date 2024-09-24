<?php
require_once 'app.php'; // Inclusie van het 'app.php'-bestand voor vereiste functies en instellingen.

// Controleert of $member een object is
if (is_object($member)) {
    // Als $member een object is, haal de waarde van de eigenschap 'stamnumber_id' op
    $stamnumber_id = $member->stamnumber_id;
} else {
    // Als $member geen object is, druk een foutmelding af
    echo "Error: Invalid member object.";
}

?>


<ul class="data--card__list">
    <li class="data--item">
        <div class="data--item__first">
            <p class="data--first">
                <?= $member->stamnumber_id ?>
            </p>

            <p class="data--name">
                <?= $member->firstname ?>
                <?= $member->lastname ?>
            </p>

            <p class="data--name">
                <?= $member->email ?>
            </p>
        </div>
        

        <a href="memberedit.php?id=<?= $member->stamnumber_id ?>" class="data--button data--button__icon">
            <img src="/images/editsvg.svg" alt="edit">
        </a>
    </li>
</ul>