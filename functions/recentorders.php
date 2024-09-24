<?php

function getRecentOrders() {
    global $db;

    $sql = "SELECT * FROM `orders`";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getMemberData($id) {
    global $db;

    $sql = "SELECT * FROM members WHERE stamnumber_id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_OBJ);
}