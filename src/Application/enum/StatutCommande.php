<?php

namespace App\Enum;

enum StatutCommande: string
{
    case CART = 'cart';
    case EN_ATTENTE = 'en_attente';
    case VALIDEE = 'validee';
    case ANNULEE = 'annulee';
    case TERMINEE = 'terminee';
}