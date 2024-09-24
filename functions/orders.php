<?php

function getOrders($search = '')
{
    global $db;

    $sql = "SELECT order_id, payed, stamnumber_id, streetname, streetnumber, town, zip FROM orders";
    if ($search) {
        $sql .= " WHERE stamnumber_id LIKE :search";
        $sql .= " OR streetname LIKE :search";
        $sql .= " OR streetnumber LIKE :search";
        $sql .= " OR town LIKE :search";
        $sql .= " OR zip LIKE :search";
    }

    $stmt = $db->prepare($sql);
    if ($search) {
        $stmt->bindValue(':search', "%$search%");
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getOrderById($id)
{
    global $db;

    $stmt = $db->prepare("SELECT * FROM orders WHERE order_id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}


function insertOrder($payed, $stamnumber_id, $streetname, $streetnumber, $town, $zip, $ring_id, $postalparcel_id)
{
    global $db;

    // Assuming you have a table named 'order_ring' to handle the relationship
    $stmt = $db->prepare("INSERT INTO orders (payed, stamnumber_id, streetname, streetnumber, town, zip, postalparcel_id) 
    VALUES (:payed, :stamnumber_id, :streetname, :streetnumber, :town, :zip, :postalparcel_id)");

    $stmt->bindValue(':payed', $payed);
    $stmt->bindValue(':stamnumber_id', $stamnumber_id);
    $stmt->bindValue(':streetname', $streetname);
    $stmt->bindValue(':streetnumber', $streetnumber);
    $stmt->bindValue(':town', $town);
    $stmt->bindValue(':zip', $zip);
    $stmt->bindValue(':postalparcel_id', $postalparcel_id);
    $stmt->execute();

    // Get the last inserted order_id
    $order_id = $db->lastInsertId();

    // Insert the relationship into the order_ring table
    $stmt = $db->prepare("INSERT INTO order_ring (order_id, ring_id) VALUES (:order_id, :ring_id)");
    $stmt->bindValue(':order_id', $order_id);
    $stmt->bindValue(':ring_id', $ring_id);
    $stmt->execute();
}

function updateOrder($id, $payed, $streetname, $streetnumber, $town, $zip)
{
    global $db;

    $stmt = $db->prepare("UPDATE orders SET payed = :payed, streetname = :streetname, streetnumber = :streetnumber, town = :town, zip = :zip WHERE order_id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':payed', $payed);
    $stmt->bindValue(':streetname', $streetname);
    $stmt->bindValue(':streetnumber', $streetnumber);
    $stmt->bindValue(':town', $town);
    $stmt->bindValue(':zip', $zip);
    $stmt->execute();
}

function deleteOrder($id)
{
    global $db;

    $stmt = $db->prepare("DELETE FROM orders WHERE order_id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
}

function getTotalOrders($order_id)
{
    global $db;

    $query = "SELECT orders.order_id, SUM(order_ring.amountto) AS total_order
              FROM orders
              JOIN order_ring ON orders.order_id = order_ring.order_id
              WHERE orders.order_id = :order_id
              GROUP BY orders.order_id";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();

    // Haal de resultaten op
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Controleer of er resultaten zijn
    if ($result) {
        return $result['total_order'];
    } else {
        return 0; // Of een andere waarde of melding afhankelijk van je behoeften
    }
}



function getTypeRings($order_id)
{
    global $db;

    $query = "SELECT rings.ring_id, rings.type
              FROM rings
              JOIN order_ring ON rings.ring_id = order_ring.ring_id
              WHERE order_ring.order_id = :order_id";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        return $result;
    } else {
        return [];
    }
}

function updateRingQuantity($order_id, $ring_id, $quantity)
{
    global $db;

    // Check if there is an existing entry for the specified order and ring
    $existingEntryQuery = "SELECT * FROM order_ring WHERE order_id = :order_id AND ring_id = :ring_id";
    $existingEntryStmt = $db->prepare($existingEntryQuery);
    $existingEntryStmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $existingEntryStmt->bindParam(':ring_id', $ring_id, PDO::PARAM_INT);
    $existingEntryStmt->execute();

    $existingEntry = $existingEntryStmt->fetch(PDO::FETCH_ASSOC);

    if ($existingEntry) {
        // If an entry already exists, update the quantity
        $updateQuery = "UPDATE order_ring SET quantity = :quantity WHERE order_id = :order_id AND ring_id = :ring_id";
        $updateStmt = $db->prepare($updateQuery);
        $updateStmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $updateStmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $updateStmt->bindParam(':ring_id', $ring_id, PDO::PARAM_INT);
        $updateStmt->execute();
    } else {
        // If no entry exists, insert a new one
        $insertQuery = "INSERT INTO order_ring (order_id, ring_id, quantity) VALUES (:order_id, :ring_id, :quantity)";
        $insertStmt = $db->prepare($insertQuery);
        $insertStmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $insertStmt->bindParam(':ring_id', $ring_id, PDO::PARAM_INT);
        $insertStmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $insertStmt->execute();
    }
}

function updateRingTotalPrice($order_id, $ring_id, $price, $quantity)
{
    global $db;

    // Calculate the total price
    $price = $price * $quantity;

    // Check if there is an existing entry for the specified order and ring
    $existingEntryQuery = "SELECT * FROM order_ring WHERE order_id = :order_id AND ring_id = :ring_id";
    $existingEntryStmt = $db->prepare($existingEntryQuery);
    $existingEntryStmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $existingEntryStmt->bindParam(':ring_id', $ring_id, PDO::PARAM_INT);
    $existingEntryStmt->execute();

    $existingEntry = $existingEntryStmt->fetch(PDO::FETCH_ASSOC);

    if ($existingEntry) {
        // If an entry already exists, update the total price
        $updateQuery = "UPDATE order_ring SET price = :price WHERE order_id = :order_id AND ring_id = :ring_id";
        $updateStmt = $db->prepare($updateQuery);
        $updateStmt->bindParam(':price', $price, PDO::PARAM_STR); // Use PARAM_STR for decimal values
        $updateStmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $updateStmt->bindParam(':ring_id', $ring_id, PDO::PARAM_INT);
        $updateStmt->execute();
    } else {
        // If no entry exists, insert a new one
        $insertQuery = "INSERT INTO order_ring (order_id, ring_id, price) VALUES (:order_id, :ring_id, :price)";
        $insertStmt = $db->prepare($insertQuery);
        $insertStmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $insertStmt->bindParam(':ring_id', $ring_id, PDO::PARAM_INT);
        $insertStmt->bindParam(':price', $price, PDO::PARAM_STR); // Use PARAM_STR for decimal values
        $insertStmt->execute();
    }
}


function getTotalPrice($order_id)
{
    global $db;

    $query = "
        SELECT orders.order_id, SUM(order_ring.price * order_ring.amountto) AS total_price
        FROM orders
        JOIN order_ring ON orders.order_id = order_ring.order_id
        WHERE orders.order_id = :order_id
        GROUP BY orders.order_id;";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the results
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if there are results
    if ($result) {
        // Ensure the total_price is treated as a decimal (float)
        return floatval($result['total_price']);
    } else {
        return 0.0; // Return 0.0 for decimal representation or adjust as needed
    }
}

function getMemberOrdersWithCounts($id)
{
    global $db;

    $sql = "SELECT m.stamnumber_id, CONCAT(m.firstname, ' ', m.lastname) AS full_name, m.firstname, m.lastname, 
    COUNT(CASE WHEN oring.type = 'BLAH' THEN oring.order_id END) AS blah_count,
    COUNT(CASE WHEN oring.type = 'INOX' THEN oring.order_id END) AS inox_count FROM members m LEFT JOIN 
    orders o ON m.stamnumber_id = o.stamnumber_id LEFT JOIN order_ring oring ON o.order_id = oring.order_id WHERE
    m.stamnumber_id LIKE :search OR m.firstname LIKE :search OR m.lastname LIKE :search GROUP BY
    m.stamnumber_id, m.firstname, m.lastname";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}