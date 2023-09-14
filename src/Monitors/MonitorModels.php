<?php

namespace Collection\Monitors;

use Collection\Monitors\Monitor;
use PDO;

class MonitorModels
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function getAllMonitors(): array
    {
        $query = $this->db->prepare("SELECT * FROM `monitors` WHERE `deleted`=0;");

        $query->execute();

        $data = $query->fetchAll();

        $monitors = []; // We define an empty array to contain the result

        foreach ($data as $monitorData) {
            // For each productData, we instantiate a Product entity
            // add it into the products array
            $monitors[] = new Monitor(
                $monitorData['id'],
                $monitorData['make'],
                $monitorData['model'],
                $monitorData['commissioned'],
                $monitorData['deleted']
            );
        }
        // Return the array of Product objects
        return $monitors;
    }


    public function insertNewMonitor(string $make, string $model, string $commissioned): Void
    {
        $query = $this->db->prepare("INSERT INTO `monitors` (`make`, `model`, `commissioned`) 
        VALUES(:make, :model, :commissioned);");

        $query->execute([
            'make' => $make,
            'model' => $model,
            'commissioned' => $commissioned
        ]);
    }

    public function removeMonitor(int $id): void
    {
        $query = $this->db->prepare("UPDATE `monitors` SET `deleted`='1' WHERE `id`=:id;");

        $query->execute([
            'id' => $id,
        ]);
    }
}
