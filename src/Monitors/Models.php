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
    
    
    public function getAllProducts(): array
    {
        $query = $this->db->prepare("SELECT * FROM `monitors`;");

        $query->execute();

        $data = $query->fetchAll();

        $products = []; // We define an empty array to contain the result

        foreach ($data as $productData) {
            // For each productData, we instantiate a Product entity
            // add it into the products array
            $products[] = new Monitors(
                $productData['id'],
                $productData['make'],
                $productData['model'],
                $productData['commissioned']
            );
        }
        // Return the array of Product objects
        return $products;
    }
}