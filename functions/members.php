<?php

function generateUniqueStamnummer()
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Lijst van alle letters
    $numbers = '0123456789'; // Lijst van alle cijfers

    $random_letter1 = $characters[rand(0, strlen($characters) - 1)]; // Kies een willekeurige letter
    $random_letter2 = $characters[rand(0, strlen($characters) - 1)]; // Kies nog een willekeurige letter

    $random_number1 = $numbers[rand(0, strlen($numbers) - 1)]; // Kies een willekeurig cijfer
    $random_number2 = $numbers[rand(0, strlen($numbers) - 1)]; // Kies nog een willekeurig cijfer
    $random_number3 = $numbers[rand(0, strlen($numbers) - 1)]; // Kies nog een willekeurig cijfer

    $stamnummer = $random_letter1 . $random_letter2 . $random_number1 . $random_number2 . $random_number3;

    return $stamnummer;
}

function getMembers($search = '')
{
    global $db;

    $sql = "SELECT stamnumber_id, firstname, lastname, email FROM members";
    if ($search) {
        $sql .= " WHERE stamnumber_id LIKE :search";
        $sql .= " OR firstname LIKE :search";
        $sql .= " OR lastname LIKE :search";
        $sql .= " OR email LIKE :search";
    }

    $sql .= " ORDER BY firstname ASC";

    $stmt = $db->prepare($sql);
    if ($search) {
        $stmt->bindValue(':search', "%$search%");
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getMemberById($id)
{
    global $db;

    $stmt = $db->prepare("SELECT * FROM members WHERE stamnumber_id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function insertMember($firstname, $lastname, $email, $streetname, $streetnumber, $town, $zip, $telephonenumber, $payed) {
    global $db;

    // Genereer een uniek stamnummer
    $stamnummer = generateUniqueStamnummer(); // Veronderstel dat je eerder een functie hebt gemaakt om dit te doen

    $stmt = $db->prepare("INSERT INTO members (stamnumber_id, firstname, lastname, email, streetname, streetnumber, town, zip, telephonenumber, payed) VALUES (:stamnumber, :firstname, :lastname, :email, :streetname, :streetnumber, :town, :zip, :telephonenumber, :payed)");
    $stmt->bindValue(':stamnumber', $stamnummer);
    $stmt->bindValue(':firstname', $firstname);
    $stmt->bindValue(':lastname', $lastname);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':streetname', $streetname);
    $stmt->bindValue(':streetnumber', $streetnumber);
    $stmt->bindValue(':town', $town);
    $stmt->bindValue(':zip', $zip);
    $stmt->bindValue(':telephonenumber', $telephonenumber);
    $stmt->bindValue(':payed', $payed); // Zorg ervoor dat $payed de juiste waarde heeft

    $stmt->execute();
}

function updateMember($id, $payed, $firstname, $lastname, $email, $streetname, $streetnumber, $town, $zip, $telephonenumber)
{
    global $db;

    $stmt = $db->prepare("UPDATE db.members SET payed = :payed, firstname = :firstname, lastname = :lastname, email = :email, streetname = :streetname, streetnumber = :streetnumber, town = :town, zip = :zip, telephonenumber = :telephonenumber WHERE stamnumber_id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':payed', $payed);
    $stmt->bindValue(':firstname', $firstname);
    $stmt->bindValue(':lastname', $lastname);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':streetname', $streetname);
    $stmt->bindValue(':streetnumber', $streetnumber);
    $stmt->bindValue(':town', $town);
    $stmt->bindValue(':zip', $zip);
    $stmt->bindValue(':telephonenumber', $telephonenumber);
    $stmt->execute();
}

function getUnpaidMembers()
{
    global $db;

    $stmt = $db->prepare("SELECT * FROM members WHERE payed = 0 ORDER BY firstname ASC LIMIT 5");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}