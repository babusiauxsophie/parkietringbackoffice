<?php

function getUser () {
    global $db;

    $sql = "SELECT * FROM db.users";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function updateUser ($id, $email, $password) {
    global $db;

    $stmt = $db->prepare("UPDATE users SET email = :email, password = :password WHERE user_id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
}
