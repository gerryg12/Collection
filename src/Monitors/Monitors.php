<?php

namespace Collection\Monitors;

// commissioned datatype?

readonly class Monitors
{
    public int $id;
    public string $make;
    public string $model;
    public string $commissioned;

    public function __construct(
        int $id, 
        string $make, 
        string $model,
        string $commissioned,
        )
    {
        $this->id = $id;
        $this->make = $make;
        $this->model = $model;
        $this->commissioned = $commissioned;
    }
}