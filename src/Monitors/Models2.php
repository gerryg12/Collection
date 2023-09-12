<?php

namespace Collection\Monitors;

use Collection\Monitors\Monitors;
use PDO;

class Models
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
    public function getMonitorById(int $id): Monitors|false
    {
        $query = $this->db->prepare('SELECT `id`, `name`, `address`, `age` FROM `customers` WHERE `id` = :id');
        $query->bindParam('id', $id);

        $query->execute();

        $data = $query->fetch();

        if (!$data) {
            return false;
        }

        $monitor = new Monitors($data['id'], $data['make'], $data['model'], $data['commissioned']);

        return $monitor;
    }
}