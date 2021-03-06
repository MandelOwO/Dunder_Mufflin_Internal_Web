<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mifflin | Home</title>

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
$stmt = $pdo->prepare('SELECT 
                                e.EmployeeName,
                                e.Surname,
                                COUNT(s.IdSale) as SaleCount
                                FROM TbSales s
                                INNER JOIN TbEmployees e on s.EmployeeId = e.IdEmployee
                                GROUP BY e.EmployeeName
                                ORDER BY COUNT(s.IdSale) DESC');
$stmt->execute();
$bestEmployee = $stmt->fetch();

$stmt = $pdo->prepare('SELECT 
                                SUM(p.Price * s.Count * (100 - s.Discount) / 100) as Total
                                FROM TbSales s
                                INNER JOIN TbProducts p on s.ProductId = p.IdProduct');
$stmt->execute();
$TotalTurnover = $stmt->fetch();

$stmt = $pdo->prepare('SELECT 
                                COUNT(IdSale) as Count
                                FROM TbSales
                                WHERE Date >= (NOW() - INTERVAL 14 DAY)');
$stmt->execute();
$SaleCount = $stmt->fetch();

$stmt = $pdo->prepare('SELECT 
                                COUNT(IdSale) as Count,
                                DATE_FORMAT( Date, "%d.%m") as Date
                                FROM TbSales
                                WHERE Date >= (NOW() - INTERVAL 7 DAY)
                                GROUP BY DATE_FORMAT(Date, "%d-%m-%y")');
$stmt->execute();
$ChartData = $stmt->fetchAll();
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
                    <a class="nav-link active" aria-current="page" href="../dashboard"><i class="bi bi-window"></i>
                        Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../employees"><i class="bi bi-person"></i> Employees</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../stock"><i class="bi bi-box-seam"></i> Stock</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../sales"><i class="bi bi-cash-stack"></i> Sales</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- /// NAVBAR -->


<main class="Container mt-5">

    <!-- STATS -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="carousel-content mt-3">
                    <h1>Best seller</h1>
                    <h4>all time</h4>
                    <h2><?= $bestEmployee['EmployeeName'] ?> <?= $bestEmployee['Surname'] ?>
                        - <?= $bestEmployee['SaleCount'] ?> sales</h2>
                </div>
            </div>
            <div class="carousel-item">
                <div class="carousel-content mt-3">
                    <h1>Turnover</h1>
                    <h4>all time</h4>
                    <h2><?= number_format($TotalTurnover['Total'], 0, ',', ' ') ?> K??</h2>
                </div>
            </div>
            <div class="carousel-item">
                <div class="carousel-content mt-3">
                    <h1>Sales</h1>
                    <h4>in last 14 days</h4>
                    <h2><?= $SaleCount['Count'] ?> sales</h2>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- /// STATS -->

    <!-- CHART -->
    <section class="container mt-5">
        <div class="row">
            <div class="col-lg-5">
                <h1>Sales in last 7 days:</h1>
                <div class="chart ">

                    <?php foreach ($ChartData as $Key => $Column): ?>
                        <div class="chartCol div-r-1" style="height: <?= $Column['Count']*10 ?>%"> <p> <?= $Column['Count'] ?></p></div>
                        <div class="div-r-2"><?= $Column['Date']  ?></div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col">
                <h1>News:</h1>
                <div class="news">
                    <p>We are <b>the best</b> paper company <b>worldwide!</b> </p> <hr>
                    <p>Remember to keep <b>working hard</b> and stay <b>motivated!</b> </p> <hr>
                    <p>New original clothing just dropped!</p>
                </div>
            </div>

        </div>

    </section>

    <!-- /// CHART -->
</main>
</body>

</html>