<?php

require '../source/db.php';

var_dump($_GET['id']);

if (isset($_GET['id'])) {

    $stmt = $pdo->prepare("UPDATE TbProducts SET DeletedAt  = :DeletedAt  WHERE IdProduct = :id ");
    $stmt->execute([
        'id' => $_GET['id'],
        'DeletedAt' => date("Y-m-d H:i:s")
    ]);
}

header('Location: index.php');

