<?php

namespace App\Repository;

use App\Entity\HostTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method HostTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method HostTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method HostTable[]    findAll()
 * @method HostTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HostTableRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, HostTable::class);
    }

    public function getRandomTable()
    {
        $result = $this->findAll();
        $rand = array_rand($result);
        return $result[$rand];
    }

    public function findLimit()
    {
        return $this->createQueryBuilder('h')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }


    public function findIndexSearch(array $array)
    {
        // Création du builder de request
        $builder = $this->createQueryBuilder('host_table');

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
                $max = 500;
                break;
        }

        // On construit une request qui va chercher les table dans les département et dans le pricerange sélectionné
        // L'expression like demande une string et un % à la fin, on commence donc par "'" pour ouvrir la string et le "%'" sert a mettre le symbole % et fermer la string
        return
            $builder
                ->where($builder->expr()->like('host_table.zipCode', "'".$array['dept'] . "%'"))
                ->andWhere($builder->expr()->between('host_table.priceRange', $min, $max))
                ->getQuery()
                ->getResult();
    }



    // /**
    //  * @return HostTable[] Returns an array of HostTable objects
    //  */
    /*

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HostTable
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
