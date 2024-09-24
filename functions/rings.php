<?php

function getRings($search='') {
    global $db;

    $sql = "SELECT ring_id, size, price, type FROM rings";
    if($search) {
        $sql .= " WHERE ring_id LIKE :search";
        $sql .= " OR size LIKE :search";
        $sql .= " OR price LIKE :search";
        $sql .= " OR type LIKE :search";
    }
    $sql .= " ORDER BY CAST(size AS DECIMAL(10,2)) ASC"; // Sorteren op 'size' als numerieke waarde

    $stmt = $db->prepare($sql);
    if ($search) {
        $stmt->bindValue(':search', "%$search%");
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getRingById($id) {
    global $db;

    $stmt = $db->prepare("SELECT * FROM rings WHERE ring_id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function updateRing($id, $size, $price, $type) {
    global $db;

    $stmt = $db->prepare("UPDATE rings SET size = :size, price = :price, type = :type WHERE ring_id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':size', $size);
    $stmt->bindValue(':price', $price);
    $stmt->bindValue(':type', $type);
    $stmt->execute();
}

function insertRing($size, $price, $type) {
    global $db;

    $stmt = $db->prepare("INSERT INTO rings (size, price, type) VALUES (:size, :price, :type)");
    $stmt->bindValue(':size', $size);
    $stmt->bindValue(':price', $price);
    $stmt->bindValue(':type', $type);
    $stmt->execute();
}

function deleteRing($id) {
    global $db;

    $stmt = $db->prepare("DELETE FROM rings WHERE ring_id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
}