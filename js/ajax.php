<?php
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'del':
                del();
                break;
            case 'edit':
                edit();
                break;
        }
    }

    function edit() {
        echo "The Edit function is called.";
        exit;
    }

    function del() {
        echo "The Delete function is called.";
        header('Location: delete.php');
        exit;
    }
?>
