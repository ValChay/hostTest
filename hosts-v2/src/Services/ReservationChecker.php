<?php
/**
 * Created by PhpStorm.
 * User: stagiaire
 * Date: 11/01/19
 * Time: 10:15
 */

namespace App\Services;


use App\Entity\Meal;
use App\Entity\Reservation;

class ReservationChecker
{
    public function checkIfCapacityOk(Meal $meal, Reservation $reservation)
    {
        // check si la reservation n'exède pas le nombre de place disponible et check si le nomre de resa saisi par le user > 0
        if ($meal->getRemainingCapacity() - $reservation->getGuestNumber() < 0 || $reservation->getGuestNumber() <= 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getErrorMessage(Meal $meal, Reservation $reservation)
    {
        if ($meal->getRemainingCapacity() - $reservation->getGuestNumber() < 0) {
            return "Il n'y pas assez de places disponible.";
        } elseif ($reservation->getGuestNumber() <= 0) {
            return "Vous ne pouvez pas faire une reservation pour moins d'une personne.";
        } else {
            return "La reservation n'a pas pu être créée.";
        }
    }
}