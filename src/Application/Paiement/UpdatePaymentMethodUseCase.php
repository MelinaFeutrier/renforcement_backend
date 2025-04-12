<?php
namespace App\Application\Paiement;

use App\Entity\User;
use App\Repository\CommandeRepository;

class UpdatePaymentMethodUseCase
{
    public function __construct(
        private CommandeRepository $commandeRepository
    ) {
        $this->commandeRepository = $commandeRepository;
    }


    public function execute(User $client, int $commandeId, string $modePaiement): void
    {
        $commande = $this->commandeRepository->findById($commandeId);

        if (!$commande) {
            throw new \InvalidArgumentException("Commande introuvable.");
        }

        if ($commande->getClient()->getId() !== $client->getId()) {
            throw new \InvalidArgumentException("Cette commande ne vous appartient pas.");
        }

        $commande->setModePaiement($modePaiement);

        $this->commandeRepository->save($commande);
    }
}