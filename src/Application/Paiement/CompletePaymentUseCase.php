<?php
namespace App\Application\Paiement;

use App\Entity\User;
use App\Repository\CommandeRepository;

class CompletePaymentUseCase
{
    public function __construct(
        private CommandeRepository $commandeRepository
    ) {
        $this->commandeRepository = $commandeRepository;
    }

    public function execute(User $client, int $commandeId): float
    {
        $commande = $this->commandeRepository->findById($commandeId);

        if (!$commande) {
            throw new \InvalidArgumentException("Commande introuvable.");
        }

        if ($commande->getClient()->getId() !== $client->getId()) {
            throw new \InvalidArgumentException("Cette commande ne vous appartient pas.");
        }

        $commande->confirmer();

        $totalPrice = $commande->getTotalPrice();

        $this->commandeRepository->save($commande);

        return $totalPrice;
    }
}