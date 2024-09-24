<?php

function getPrices() {
    global $db;

    $sql = "SELECT * FROM db.postalparcels";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}