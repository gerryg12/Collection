<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php

    use Collection\Monitors\MonitorModels;

    require_once 'vendor/autoload.php';

    // Getting connected
    $db = new PDO('mysql:host=db; dbname=collection', 'root', 'password');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $model = new MonitorModels($db);

    $monitors = $model->getAllMonitors();

    foreach ($monitors as $monitor) {
        echo "$monitor->id\n" . "$monitor->make\n" . "$monitor->model\n" . $monitor->commissioned . "<br>";
    }

    ?>

    <form method="POST">
        <label for="make">Make:</label>
        <input type="text" id="make" name="make">
        <label for="model">Model:</label>
        <input type="text" id="model" name="model">
        <label for="commissioned">Commissioned Date: e.g. 2009-01-23:</label>
        <input type="text" id="commissioned" name="commissioned"><br>
        <input type="submit" value="Submit">
    </form>
    <form method="POST">
        <label for="id">Delete ID:</label>
        <input type="text" id="id" name="id">
        <input type="submit" value="Submit">
    </form>

    <?php

    $valid = true;

    if (isset($_POST['make'])) {
        $inputtedMake = $_POST['make'];
        if (strlen($inputtedMake) == 0) {
            echo "no make inputted";
            $valid = false;
        } elseif (strlen($inputtedMake) > 12) {
            echo "Make is too long";
            $valid = false;
        }
    } else {
        $valid = false;
    }

    if (isset($_POST['model'])) {
        $inputtedModel = $_POST['model'];
        if (strlen($inputtedModel) == 0) {
            echo "no model inputted";
            $valid = false;
        } elseif (strlen($inputtedModel) > 12) {
            echo "Model is too long";
            $valid = false;
        }
    } else {
        $valid = false;
    }

    if (isset($_POST['commissioned'])) {
        $inputtedCommissioned = $_POST['commissioned'];
        if (strlen($inputtedCommissioned) == 0) {
            echo "no date inputted";
            $valid = false;
        } elseif (strlen($inputtedCommissioned) > 12) {
            echo "Date is too long";
            $valid = false;
        } elseif (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $inputtedCommissioned)) {
            echo "Date format invalid";
            $valid = false;
        }
    } else {
        $valid = false;
    }

    // $iputtedModel = $_POST['model'];
    // $inputtedCommissioned = $_POST['commissioned'];
    if ($valid == true) {
        $insertMonitor = new MonitorModels($db);
        $insertMonitor->insertNewMonitor($inputtedMake, $inputtedModel, $inputtedCommissioned);
    } else {
        echo "Not all info correct";
    }


    ?>

    <?php

    $validDelete = true;
    if (isset($_POST['id'])) {
        $inputtedId = $_POST['id'];
        if (strlen($inputtedId) == 0) {
            echo "no ID inputted";
            $validDelete = false;
        } elseif (strlen($inputtedId) > 4) {
            echo "ID is too long";
            $validDelete = false;
        }
    }

    var_dump($_POST);
    if ($validDelete == true) {
        $removeMonitor = new MonitorModels($db);
        $removeMonitor->removeMonitor($inputtedId);
    } else {
        echo "Not all info correct to delete";
    }
    ?>

</body>

</html>