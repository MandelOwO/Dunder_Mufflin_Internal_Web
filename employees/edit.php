<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mufflin | Employees - Edit employee</title>

    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link rel="stylesheet" href="../styles/style.css">


</head>

<body>
    <?php require '../source/db.php' ?>

    <?php
    if (isset($_GET['id'])) {
        $stmt = $pdo->prepare('SELECT * FROM TbEmployees WHERE IdEmployee = :id');
        $stmt->execute(['id' => $_GET['id']]);

        $row = $stmt->fetch();
    }
    ?>


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

        <form action="" method="POST">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col mt-2">
                        <button type="submit" class="btn btn-dark">Save</button>
                        <a type="button" class="btn btn-danger" href="index.php">Discard</a>
                    </div>
                </div>
            </div>


            <div class="container mt-5">
                <div class="row">
                    <div class="input-group mb-3">
                        <span class="input-group-text">First and last name</span>
                        <input type="text" aria-label="First name" class="form-control" name="Name" value="<?php echo isset($_GET['id']) ? $row['Name'] : '' ?>" required>
                        <input type="text" aria-label="Last name" class="form-control" name="Surname" value="<?php echo isset($_GET['id']) ? $row['Surname'] : '' ?>" required>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">E-Mail</span>
                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="Mail" value="<?php echo isset($_GET['id']) ? $row['Mail'] : '' ?>" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Birth Date</span>
                    <input type="date" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="BirthDate" value="<?php echo isset($_GET['id']) ? $row['BirthDate'] : '' ?>">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Job</span>
                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="Job" value="<?php echo isset($_GET['id']) ? $row['Job'] : '' ?>" required>
                </div>
                <a class="btn btn-outline-danger" type="button" href="delete.php?id=<?= $row['IdEmployee'] ?>"><i class="bi bi-trash-fill"></i></a>
            </div>
        </form>

    </main>

    <?php

    if (isset($_POST) && !empty($_POST)) {

        if (isset($_GET['id'])) {
            $stmt = $pdo->prepare("UPDATE TbEmployees SET  Name = :Name, Surname = :Surname, Mail = :Mail, BirthDate = :BirthDate, Job = :Job WHERE IdEmployee = :id");
            $stmt->execute([
                'Name' => $_POST['Name'],
                'Surname' => $_POST['Surname'],
                'BirthDate' => $_POST['BirthDate'],
                'Mail' => $_POST['Mail'],
                'Job' => $_POST['Job'],
                'id' => $_GET['id']
            ]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO TbEmployees (Name, Surname, Mail, BirthDate, Job)
            VALUES (:Name, :Surname, :Mail, :BirthDate, :Job)");
            $stmt->execute([
                'Name' => $_POST['Name'],
                'Surname' => $_POST['Surname'],
                'BirthDate' => $_POST['BirthDate'],
                'Mail' => $_POST['Mail'],
                'Job' => $_POST['Job']
            ]);
        }



        echo ("<script>location.href = 'index.php';</script>");
    }
    ?>

    <!-- Go to top btn -->
    <div id="ToTopBtn"></div>
    <script>
        $(function() {
            $("#ToTopBtn").load("source/ToTopBtn.html");
        });
    </script>



</body>

</html>