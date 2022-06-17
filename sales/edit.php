<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mifflin | Stock - Edit sale</title>

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
if (isset($_GET['id'])) {
    /** @noinspection PhpUndefinedVariableInspection */
    /** @noinspection SqlNoDataSourceInspection */
    $stmt = $pdo->prepare('SELECT * FROM TbSales
                                INNER JOIN TbProducts on TbSales.ProductId = TbProducts.IdProduct
                                INNER JOIN TbEmployees on TbSales.EmployeeId = TbEmployees.IdEmployee
                                WHERE IdSale = :id');
    $stmt->execute(['id' => $_GET['id']]);

    $sales = $stmt->fetch();
}

$stmt = $pdo->prepare('SELECT * FROM TbEmployees WHERE DeletedAt IS NULL');
$stmt->execute();
$employees = $stmt->fetchAll();

$stmt = $pdo->prepare('SELECT * FROM TbProducts WHERE DeletedAt IS NULL');
$stmt->execute();
$products = $stmt->fetchAll();
?>


<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Eighth navbar example">
    <div class="container">
        <a class="navbar-brand" href="../dashboard">Mifflin System</a>
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
                <select name="Employee" id="Employee" class="form-select input-group">
                    <?php
                    foreach ($employees as $key => $employee) { ?>
                        <option value="<?= $employee['IdEmployee'] ?>" <?php echo(isset($_GET['id']) && $sales['EmployeeId'] == $employee['IdEmployee'] ? 'Selected' : '' ); ?>>
                            <?= $employee['EmployeeName'] ?> <?= $employee['Surname'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Product</span>
                <select name="Product" id="Product" class="form-select input-group">
                    <?php
                    foreach ($products as $key => $product) { ?>
                        <option value="<?= $product['IdProduct'] ?>" <?php echo(isset($_GET['id']) && $sales['ProductId'] == $product['IdProduct'] ? 'Selected' : '' ); ?>>
                            <?= $product['ProductName'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Count</span>
                <input type="number" class="form-control" name="Count"
                       value="<?php echo isset($_GET['id']) ? $sales['Count'] : '' ?>" required>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Time</span>
                <input type="datetime-local" class="form-control" name="Date"
                       value="<?php echo isset($_GET['id']) ? $sales['Date'] : date("Y-m-d H:i:s") ?>">
            </div>

            <div class="bottom ">
                <div>
                    <label for="Discount">
                        <input type="checkbox" name="Discount" id="Discount" value="10" <?php echo(isset($_GET['id']) && $sales['Discount'] == 10 ? 'Checked':''); ?>>
                        10% Discount
                    </label>
                </div>

                <div class="">
                    <?php if (isset($_GET['id'])) : ?>
                        <p>Price:
                            <?php
                            $price = $price = $sales['Price'] * $sales['Count'] * (100 - $sales['Discount']) / 100;
                            echo number_format($price, 0, ',', ' ') . ' Kč';
                            ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

<!--
            <div class="input-group mb-3">
                <label class="me-3">
                    No Discount
                    <input type="radio" name="DiscountSelection" value="0" required checked>
                </label>
                <label class="me-3">
                    10%
                    <input type="radio" name="DiscountSelection" value="10" required>
                </label>
                <label class="me-3">
                    Custom Discount
                    <input type="radio" name="DiscountSelection" value="-1" required>
                </label>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Custom Discount</span>
                <input type="number" class="form-control" name="CustomDiscount"
                       value="<?php echo isset($_GET['id']) ? $sales['Discount'] : '' ?>">
            </div>
-->

        </div>
    </form>

    <!-- /// FORM -->

</main>

<?php
if (isset($_POST) && !empty($_POST)) {
    /*
    if ($_POST['DiscountSelection'] == 0) {
        $Discount = 0;
    } else if ($_POST['DiscountSelection'] == 10) {
        $Discount = 10;
    } else if ($_POST['DiscountSelection'] == -1) {
        $Discount = $_POST['CustomDiscount'];
    }
*/
    if (!isset($_POST['Discount'])){
        $_POST['Discount'] = 0;
    }
    if (isset($_GET['id'])) {
        $stmt = $pdo->prepare("UPDATE TbSales SET EmployeeId = :EmployeeId, ProductId = :ProductId, Count = :Count, Discount = :Discount, Date = :Date WHERE IdSale = :id");
        $stmt->execute([
            'EmployeeId' => $_POST['Employee'],
            'ProductId' => $_POST['Product'],
            'Discount' => $_POST['Discount'],
            'Count' => $_POST['Count'],
            'Date' => $_POST['Date'],
            'id' => $_GET['id']
        ]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO TbSales (EmployeeId, ProductId, Discount, Count, Date)
            VALUES (:EmployeeId, :ProductId, :Discount, :Count, :Date)");
        $stmt->execute([
            'EmployeeId' => $_POST['Employee'],
            'ProductId' => $_POST['Product'],
            'Discount' =>$_POST['Discount'],
            'Date' => $_POST['Date'],
            'Count' => $_POST['Count']
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