<?php

namespace Collection\Monitors;

// commissioned datatype?

readonly class Monitor
{
    public int $id;
    public string $make;
    public string $model;
    public string $commissioned;
    public int $deleted;

    public function __construct(
        int $id, 
        string $make, 
        string $model,
        string $commissioned,
        int $deleted
        )
    {
        $this->id = $id;
        $this->make = $make;
        $this->model = $model;
        $this->commissioned = $commissioned;
        $this->deleted = $deleted;
    }
}