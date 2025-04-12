<?php
namespace App\Application\Commande;

use App\Entity\User;
use App\Enum\StatutCommande;
use App\Repository\CommandeRepository;

class ListCommandeUseCase
{
    public function __construct(
        private CommandeRepository $commandeRepository
    ) {
        $this->commandeRepository = $commandeRepository;
    }

    /**
     * Liste les commandes d'un client, optionnellement filtrées par statut
     */
    public function execute(User $client, ?StatutCommande $statut = null): array
    {

        return $this->commandeRepository->findByClient($client, $statut);
    }
}