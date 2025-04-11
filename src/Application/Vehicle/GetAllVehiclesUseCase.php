<?php

namespace App\Application\Vehicle;

use App\Repository\VehicleRepository;

class GetAllVehiclesUseCase
{
    public function __construct(private VehicleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        return $this->repository->findAll();
    }
}