<?php

require '../source/db.php';

var_dump($_GET['id']);

if (isset($_GET['id'])) {

    $stmt = $pdo->prepare("UPDATE TbEmployees SET DeletedAt  = :DeletedAt  WHERE IdEmployee = :id ");
    $stmt->execute([
        'id' => $_GET['id'],
        'DeletedAt' => date("Y-m-d H:i:s")
    ]);
}

header('Location: index.php');

