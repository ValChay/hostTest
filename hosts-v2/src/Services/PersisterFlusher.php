<?php
/**
 * Created by PhpStorm.
 * User: stagiaire
 * Date: 11/01/19
 * Time: 15:33
 */

namespace App\Services;


use Doctrine\Common\Persistence\ObjectManager;
use PhpParser\Node\Expr\Cast\Object_;

class PersisterFlusher
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function persistAndFlush($object)
    {
        $this->manager->persist($object);
        $this->manager->flush();
        return $object->getId();
    }
}