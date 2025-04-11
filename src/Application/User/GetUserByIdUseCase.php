<?php
namespace App\Application\User;

use App\Repository\UserRepository;
use App\Entity\User;

class GetUserByIdUseCase
{
    public function __construct(private UserRepository $userRepository) {}

    public function execute(int $id): ?User
    {
        return $this->userRepository->find($id);
    }
}