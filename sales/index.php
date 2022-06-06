<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mufflin | Sales</title>

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
<?php require '../source/db.php' ?>

<?php

if (isset($_GET['search'])) {
    $search = $_GET['search'];
} else {
    $search = "";
}


/** @noinspection PhpUndefinedVariableInspection */
$stmt = $pdo->prepare('SELECT * FROM TbSales
                                INNER JOIN TbProducts on TbSales.ProductId = TbProducts.IdProduct
                                INNER JOIN TbEmployees on TbSales.EmployeeId = TbEmployees.IdEmployee
                                WHERE ProductName like "%" :srch or IdSale like "%" :srch or EmployeeName like "%" :srch or Surname like "%" :srch
                                ORDER BY IdSale DESC');
$stmt->execute(['srch' => $search]);

$sales = $stmt->fetchAll();

/*
var_dump($sales);
echo('<hr>');
foreach ($sales as $key => $sale) {
    var_dump($sale['TbProducts']['Name']);
}
*/
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
                    <a class="nav-link" aria-current="page" href="../dashboard"><i class="bi bi-window"></i>
                        Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../employees"><i class="bi bi-person"></i> Employees</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../stock"><i class="bi bi-box-seam"></i> Stock</a>
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
    <div class="d-flex justify-content-between">
        <div class="">
            <a type="button" class="btn btn-dark" href="edit.php">Add</a>
        </div>
        <div class="d-flex justify-content-end">
            <form class=" ">
                <div class="d-flex justify-content-end">
                    <input type="text" class="form-control" aria-describedby="Search" name="search">
                    <button type="submit" class="btn btn-dark ms-2"><i class="bi bi-search "></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /// BUTTONS -->

    <!-- TABLE -->

    <div class="table-responsive mt-3">
        <table class="table ">
            <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Seller</th>
                <th scope="col">Product</th>
                <th scope="col">Count</th>
                <th scope="col">Price</th>
                <th scope="col">Date</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($sales as $key => $sale) : ?>
                <tr>
                    <td>
                        <div><?= $sale['IdSale'] ?> </div>
                    </td>
                    <td>
                        <div><?= $sale['EmployeeName'] ?> <?= $sale['Surname'] ?>  </div>
                    </td>
                    <td>
                        <div><?= $sale['ProductName'] ?></div>
                    </td>
                    <td>
                        <div><?= $sale['Count'] ?></div>
                    </td>
                    <td>
                        <div><?php $price = $sale['Price'] * $sale['Count'] * (100 - $sale['Discount']) / 100;
                            echo($price); ?></div>
                    </td>
                    <td>
                        <div><?= $sale['Date'] ?></div>
                    </td>
                    <th class="table-tools">
                        <div class="input-group ">
                            <a class="btn btn-outline-secondary" type="button"
                               href="edit.php?id=<?= $sale['IdProduct'] ?>"><i class="bi bi-wrench"></i></a>
                        </div>
                    </th>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- /// TABLE -->

</main>

<!-- GO TO TOP BTN -->
<div id="ToTopBtn"></div>
<script>
    $(function () {
        $("#ToTopBtn").load("../source/ToTopBtn.html");
    });
</script>
<!-- /// GO TO TOP BTN -->


</body>
</html>