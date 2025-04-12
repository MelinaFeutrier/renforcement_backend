<?php
namespace App\Application\Assurance;

use App\Entity\User;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManager;

class AddInsuranceUseCase
{
    public function __construct(
        private CommandeRepository $commandeRepository,
        private EntityManager $entityManager,
    ) {
        $this->commandeRepository = $commandeRepository;
        $this->entityManager = $entityManager;
    }


    public function execute(User $client, int $commandeId, int $reservationId): float
    {
        $commande = $this->commandeRepository->findById($commandeId);

        if (!$commande) {
            throw new \InvalidArgumentException("Commande introuvable.");
        }

        if ($commande->getClient()->getId() !== $client->getId()) {
            throw new \InvalidArgumentException("Cette commande ne vous appartient pas.");
        }

        $reservation = null;
        foreach ($commande->getReservations() as $res) {
            if ($res->getId() === $reservationId) {
                $reservation = $res;
                break;
            }
        }

        if (!$reservation) {
            throw new \InvalidArgumentException("Réservation introuvable dans cette commande.");
        }


        $reservation->addInsurance();

        $commande->notifyReservationPriceChanged();

        $this->entityManager->flush();

        return $commande->getTotalPrice();
    }
}