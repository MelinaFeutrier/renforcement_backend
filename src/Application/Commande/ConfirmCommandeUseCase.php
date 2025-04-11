<?php
namespace App\Application\Commande;

use App\Entity\Commande;
use App\Enum\statutCommande;
use Doctrine\ORM\EntityManagerInterface;

class ConfirmCommandeUseCase
{
    public function __construct(private EntityManagerInterface $em) {}

    public function execute(Commande $commande): void
    {
        if ($commande->getStatut() !== StatutCommande::CART) {
            throw new \LogicException("Seules les commandes en 'panier' peuvent être confirmées.");
        }

        $commande->setStatut(StatutCommande::VALIDEE);
        $this->em->flush();
    }
}