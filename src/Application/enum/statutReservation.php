<?php

namespace App\Enum;

enum StatutReservation: string
{
    case EN_ATTENTE = 'en_attente';
    case VALIDEE = 'validee';
    case ANNULEE = 'annulee';
}