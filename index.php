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
    echo "$monitor->make\n"."$monitor->model\n".$monitor->commissioned."<br>";
}

?>

</body>
</html>
