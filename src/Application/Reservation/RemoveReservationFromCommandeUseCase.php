<?php

namespace App\Application\Reservation;

use App\Entity\User;
use App\Repository\CommandeRepository;
use App\Repository\ReservationRepository;

class RemoveReservationFromCommandeUseCase
{
    private CommandeRepository $commandeRepository;
    private ReservationRepository $reservationRepository;

    public function __construct(
        CommandeRepository $commandeRepository,
        ReservationRepository $reservationRepository
    ) {
        $this->commandeRepository = $commandeRepository;
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * Retire une réservation d'une commande
     */
    public function execute(User $client, int $commandeId, int $reservationId)
    {
        $commande = $this->commandeRepository->findById($commandeId);

        if (!$commande) {
            throw new \InvalidArgumentException("Commande introuvable");
        }

        if ($commande->getClient()->getId() !== $client->getId()) {
            throw new \InvalidArgumentException("Vous n'êtes pas autorisé à modifier cette commande");
        }

        $reservation = $this->reservationRepository->findById($reservationId);

        if (!$reservation) {
            throw new \InvalidArgumentException("Réservation introuvable");
        }

        $commande->retirerReservation($reservation);

        $this->commandeRepository->save($commande);

        return $commande;
    }
}