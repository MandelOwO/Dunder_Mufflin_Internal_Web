<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mufflin | Employees</title>

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


$stmt = $pdo->prepare('SELECT * FROM TbEmployees WHERE DeletedAt is null and (EmployeeName like "%" :srch or Surname like "%" :srch or IdEmployee like "%" :srch or Job like "%" :srch or Mail like "%" :srch)');
$stmt->execute(['srch' => $search]);

$employees = $stmt->fetchAll();

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
<!-- /// NAVBAR -->


<main class="Container mt-5">

    <!-- BUTTONS -->
    <div class="d-flex justify-content-between">
        <div class="">
            <a type="button" class="btn btn-dark" href="edit.php">Add</a>
            <!--
            <a type="button" class="btn btn-dark" href="edit.php">Edit selected</a>
            <input type="submit" class="button btn btn-dark" name="del" value="Delete selected">
             -->
        </div>
        <div class="d-flex justify-content-end">
            <form class="" method="GET">
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
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Job</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($employees as $empKey => $employee) : ?>
                <tr>
                    <th scope="row">
                        <div>
                            <?= $employee['IdEmployee'] ?>
                        </div>
                        <!--
                                    <label for="id[]">
                                        <input type="checkbox" name="id[]" value="<?= $employee['IdEmployee'] ?>">
                                        <?= $employee['IdEmployee'] ?>
                                    </label>
                                     -->
                    </th>
                    <td>
                        <div><?= $employee['EmployeeName'] ?> </div>
                    </td>
                    <td>
                        <div><?= $employee['Surname'] ?></div>
                    </td>
                    <td>
                        <div><?= $employee['Job'] ?></div>
                    </td>
                    <th class="table-tools">
                        <div class="input-group ">
                            <a class="btn btn-outline-secondary" type="button"
                               href="edit.php?id=<?= $employee['IdEmployee'] ?>"><i class="bi bi-wrench"></i></a>
                            <a class="btn btn-outline-danger" type="button"
                               href="delete.php?id=<?= $employee['IdEmployee'] ?>"><i class="bi bi-trash-fill"></i></a>
                        </div>
                    </th>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- /// TABLE -->

    <!--
            <?php
    print_r($_POST);
    if (isset($_POST['del'])) {
        var_dump($_POST['id']);
        //  echo("<script>location.href = 'index.php?='".$_POST['id'].";</script>");
    }
    ?>
        -->
</main>

<!-- GO TO TOP BTN -->
<div id="ToTopBtn"></div>
<script>
    $(function () {
        $("#ToTopBtn").load("../source/ToTopBtn.html");
    });
</script>
<!-- /// GO TO TOP BTN -->


<!--
<script>
    $(document).ready(function() {
        $('.button').click(function() {
            var clickBtnValue = $(this).val();
            var ajaxurl = '../js/ajax.php',
                data = {
                    'action': clickBtnValue
                };
            $.post(ajaxurl, data, function(response) {
                // Response div goes here.

                alert("action performed successfully");
            });
        });
    });
</script>
-->

</body>

</html>