<?php
namespace App\Application\Commande;

use App\Entity\Commande;
use App\Entity\User;
use App\Entity\Vehicle;
use App\Repository\CommandeRepository;
use App\Repository\VehicleRepository;

class CreateCommandeUseCase
{
    public function __construct(
        private CommandeRepository $commandeRepository,
        private VehicleRepository $vehicleRepository
    ) {
        $this->commandeRepository = $commandeRepository;
        $this->vehicleRepository = $vehicleRepository;
    }


    public function execute(User $client, string $modePaiement, array $lignesData = []): Commande
    {
        $panierExistant = $this->commandeRepository->findCartByClient($client);

        $commande = $panierExistant ?: new Commande($client, $modePaiement);

        foreach ($lignesData as $ligne) {
            $vehicule = $this->vehicleRepository->findById($ligne['vehicle_id']);
            if (!$vehicule) {
                throw new \InvalidArgumentException("Véhicule non trouvé : {$ligne['vehicle_id']}");
            }

            $dateDebut = new \DateTimeImmutable($ligne['dateDebut']);
            $dateFin = new \DateTimeImmutable($ligne['dateFin']);

            $reservation = $commande->ajouterReservation($vehicule, $dateDebut, $dateFin);

            if (isset($ligne['assurance']) && $ligne['assurance'] === true) {
                $reservation->addInsurance();
            }
        }

        $this->commandeRepository->save($commande);

        return $commande;
    }
}