<?php
namespace App\Application\Commande;

use App\Enum\StatutCommande;
use App\Entity\User;
use App\Repository\CommandeRepository;

class ListCommandeUseCase
{
    public function __construct(private CommandeRepository $repository) {}

    public function execute(User $client, ?StatutCommande $statut = null): array
    {
        return $this->repository->findByClient($client, $statut);
    }
}