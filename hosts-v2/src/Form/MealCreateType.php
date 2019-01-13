<?php

namespace App\Form;

use App\Entity\HostTable;
use App\Entity\Meal;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MealCreateType extends AbstractType
{
    public function __construct()
    {

    }

    // le query_builder sert a chercher les tables de l'utilisateur logué
    // le user vient du controller
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        $builder
            ->add('name')
            ->add('date')
            ->add('hostTable', EntityType::class, array(
                'class' => HostTable::class,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('u')
                        ->where('u.user = :uid')
                        ->setParameter('uid', $user);
                },
                'choice_label' => 'name'))
            ->add('price')
            ->add('menu')
            ->add('capacity');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Meal::class,
            'user' => null
        ]);
    }
}
