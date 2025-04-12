<?php
namespace App\Application\Commande;

use App\Entity\Commande;
use App\Repository\CommandeRepository;

class CancelCommandeUseCase
{
    public function __construct(
        private CommandeRepository $commandeRepository
    ) {}

    /**
     * Annule une commande
     */
    public function execute(Commande $commande): void
    {
        $commande->annuler();

        $this->commandeRepository->save($commande);
    }
}