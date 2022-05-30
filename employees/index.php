<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mufflin | Employees</title>

    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link rel="stylesheet" href="../styles/style.css">


</head>

<body>
    <?php require '../source/db.php' ?>


    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Eighth navbar example">
        <div class="container">
            <a class="navbar-brand" href="../dashboard">Mufflin System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="../dashboard"><i class="bi bi-window"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../employees"><i class="bi bi-person"></i> Employees</a>
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


    <main class="Container mt-5">

        <div class="container">
            <div class="row row-cols-1 row-cols-md-2 ">
                <div class="col mt-2">
                    <a type="button" class="btn btn-dark" href="edit.php">Add</a>
                    <a type="button" class="btn btn-dark" href="edit.php">Edit selected</a>
                    <a type="button" class="btn btn-dark" href="edit.php">Delete selected</a>
                </div>
                <div class="col ">
                    <form class="d-flex justify-content-md-end mt-2">
                        <input type="text">
                        <button type="button" class="btn btn-dark ms-2" href="edit.php" ><i class="bi bi-search "></i></button>
                    </form>
                </div>
            </div>
        </div>

        <!-- TABLE -->

        <?php
        $stmt = $pdo->prepare('SELECT * FROM TbEmployees');
        $stmt->execute();

        $employees = $stmt->fetchAll();
        ?>

        <div class="table-responsive mt-3">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Job</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employees as $empKey => $employee) : ?>
                        <tr>
                            <th scope="row">
                                <input type="checkbox" name="IdEmployee" id="<?= $empKey + 1 ?>">
                                <a href="edit.php?id=<?= $empKey + 1 ?>"> 1 </a>
                            </th>
                            <td><?= $employee['Name'] ?></td>
                            <td><?= $employee['Surname'] ?></td>
                            <td><?= $employee['Job'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

        </div>

        <!-- Go to top btn -->
        <div id="ToTopBtn"></div>
        <script>
            $(function() {
                $("#ToTopBtn").load("source/ToTopBtn.html");
            });
        </script>
    </main>




</body>

</html>