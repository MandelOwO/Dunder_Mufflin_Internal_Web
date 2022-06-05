<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mufflin | Stock - Edit sale</title>

    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link rel="stylesheet" href="../styles/style.css">


</head>

<body>
/** @noinspection SqlNoDataSourceInspection */<?php require '../source/db.php' ?>

<?php
if (isset($_GET['id'])) {
    /** @noinspection PhpUndefinedVariableInspection */
    /** @noinspection SqlNoDataSourceInspection */
    $stmt = $pdo->prepare('SELECT * FROM TbSales
                                INNER JOIN TbProducts on TbSales.ProductId = TbProducts.IdProduct
                                INNER JOIN TbEmployees on TbSales.EmployeeId = TbEmployees.IdEmployee
                                WHERE IdSale = :id');
    $stmt->execute(['id' => $_GET['id']]);

    $row = $stmt->fetch();
}
?>


<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Eighth navbar example">
    <div class="container">
        <a class="navbar-brand" href="../dashboard">Mufflin System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
                aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="../dashboard"><i class="bi bi-window"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="../employees"><i class="bi bi-person"></i> Employees</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="../stock"><i class="bi bi-box-seam"></i> Stock</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../sales"><i class="bi bi-cash-stack"></i> Sales</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- /// NAVBAR -->

<main class="Container mt-5">

    <!-- BUTTONS -->
    <form action="" method="POST">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col mt-2">
                    <button type="submit" class="btn btn-dark">Save</button>
                    <a type="button" class="btn btn-danger" href="index.php">Discard</a>
                </div>
            </div>
        </div>
        <!-- /// BUTTONS -->

        <!-- FORM -->
        <div class="container mt-5">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Seller</span>

                <select name="Category" id="Category" class="form-select input-group">
                    <?php
                    foreach ($row as $key => $sale) { ?>
                        <option value="p<?= $sale['IdEmployee'] ?>" <?php echo (isset($_GET['id']) && $row['Category'] == 'Paper') ? 'selected' : '' ?>>
                            <?= ?>
                        </option>
                    <?php } ?>
                    ?>
                </select>


            </div>

        </div>
    </form>

    <!-- /// FORM -->

</main>

<?php

if (isset($_POST) && !empty($_POST)) {

    if (isset($_GET['id'])) {
        $stmt = $pdo->prepare("UPDATE TbProducts SET  ProductName = :ProductName, Description = :Description, Price = :Price, Category = :Category WHERE IdProduct = :id");
        $stmt->execute([
            'ProductName' => $_POST['ProductName'],
            'Description' => $_POST['Description'],
            'Category' => $_POST['Category'],
            'Price' => $_POST['Price'],
            'id' => $_GET['id']
        ]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO TbProducts (ProductName, Description, Price, Category)
            VALUES (:ProductName, :Description, :Price, :Category)");
        $stmt->execute([
            'ProductName' => $_POST['ProductName'],
            'Description' => $_POST['Description'],
            'Price' => $_POST['Price'],
            'Category' => $_POST['Category']
        ]);
    }
    echo("<script>location.href = 'index.php';</script>");
}
?>

<!-- Go to top btn -->
<div id="ToTopBtn"></div>
<script>
    $(function () {
        $("#ToTopBtn").load("source/ToTopBtn.html");
    });
</script>

</body>

</html>