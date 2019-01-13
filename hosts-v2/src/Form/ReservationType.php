<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('meal', null, array(
                'choice_label' => function ($choiceValue, $key, $value) {
                    $tableName = $choiceValue->getHostTable()->getName();
                    $dateTime = $choiceValue->getDate()->format('Y-m-d H');
                    return  $tableName. ' / ' . $dateTime . 'h';
                    }))
//            ->add('meal', null, array(
//                'choice_label' => 'date',
//            ))
            ->add('guestNumber')
            ->add('user', null, array(
                'choice_label' => 'email'
            ))
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
