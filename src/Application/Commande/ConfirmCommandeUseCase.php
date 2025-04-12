<?php

namespace App\Application\Commande;

use App\Entity\Commande;
use App\Repository\CommandeRepository;

class ConfirmCommandeUseCase
{
    private CommandeRepository $commandeRepository;

    public function __construct(CommandeRepository $commandeRepository)
    {
        $this->commandeRepository = $commandeRepository;
    }

    /**
     * Confirme une commande (la fait passer de l'état panier à confirmée)
     */
    public function execute(Commande $commande): float
    {
        $commande->confirmer();

        $this->commandeRepository->save($commande);

        return $commande->getTotalPrice();
    }
}