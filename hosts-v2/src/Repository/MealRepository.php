<?php

namespace App\Repository;

use App\Entity\Meal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Meal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meal[]    findAll()
 * @method Meal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Meal::class);
    }

    public function findLimit()
    {
        return $this->createQueryBuilder('h')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function findIndexSearch(array $array)
    {
        // Création du builder de request
        $builder = $this->createQueryBuilder('meal');

        // Le formulaire renvoi 3 pricerange, selon le price range un prix mini et maxi est défini
        switch ($array['price']){
            case 1:
                $min = 0;
                $max = 30;
                break;
            case 2:
                $min = 30;
                $max = 50;
                break;
            case 3:
                $min = 50;
                $max = 5000000;
                break;
        }

        // On construit une request qui va chercher les table dans les département et dans le pricerange sélectionné
        // L'expression like demande une string et un % à la fin, on commence donc par "'" pour ouvrir la string et le "%'" sert a mettre le symbole % et fermer la string
        return
            $builder
                ->join('meal.hostTable', 'table')
                ->where($builder->expr()->like('table.zipCode', "'".$array['dept'] . "%'"))
                ->andWhere($builder->expr()->between('meal.price', $min, $max))
                ->getQuery()
                ->getResult();
    }

    public function findUserMeal($idUser)
    {
        $builder = $this->createQueryBuilder('meal');

        return
            $builder
            ->join('meal.reservations', 'reservations')
            ->join('reservations.user',  'user')
            ->where('user.id ='.$idUser)
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Meal[] Returns an array of Meal objects
    //  */
    /*$builder->$builder->
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Meal
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
