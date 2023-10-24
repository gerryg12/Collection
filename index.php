<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">

    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <h1>Monitor List</h1>


    <?php

    use Collection\Monitors\MonitorModels;

    require_once 'vendor/autoload.php';

    // Getting connected
    $db = new PDO('mysql:host=db; dbname=collection', 'root', 'password');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $model = new MonitorModels($db);

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


    if ((isset($_POST['make'])) || (isset($_POST['model'])) || (isset($_POST['commissioned']))) {
        if ($valid == true) {
            $insertMonitor = new MonitorModels($db);
            $insertMonitor->insertNewMonitor($inputtedMake, $inputtedModel, $inputtedCommissioned);
        } else {
            echo "Not all info correct";
        }
    }

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
    } else {
        $validDelete = false;
    }

    // var_dump($_POST);
    if (isset($_POST['id'])) {
        if ($validDelete == true) {
            $removeMonitor = new MonitorModels($db);
            $removeMonitor->removeMonitor($inputtedId);
        } else {
            echo "Not all info correct to delete";
        }
    }



    ?>

  <div class="about">
    <h2>Current Monitor List</h2>
  </div>


  <div class="test">
  <?php

$monitors = $model->getAllMonitors();

foreach ($monitors as $monitor) {
    echo "$monitor->id\n" . "$monitor->make\n" . "$monitor->model\n" . $monitor->commissioned . "<br>";
}
?>
</div>
  
<div class="addmodel">
<!-- <p>Please add monitor</p> -->
    <form method="POST">
    <p class="monitorask">Please add monitor<br></p>
        <label for="make">Make:</label>
        <input type="text" id="make" name="make">
        <label for="model">Model:</label>
        <input type="text" id="model" name="model">
        <label for="commissioned">Commissioned Date: e.g. 2009-01-23:</label>
        <input type="text" id="commissioned" name="commissioned">
        <input type="submit" value="Submit">
    </form>
</div>


<div class="delete">
    <p>Select Monitor ID to delete</p><br>
    <form method="POST">
        <label for="id">:</label>
        <input type="number" id="id" name="id">
        <input type="submit" value="Submit">
    </form>
</div>



</body>

</html>