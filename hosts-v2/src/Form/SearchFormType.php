<?php

namespace App\Form;

use App\Entity\HostTable;
use function PHPSTORM_META\type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dept', ChoiceType::class, [
                'choices'  => array(
                    '44' => '44',
                    '35' => '35',
                    '75' => '75',
                )
            ])->add('price', ChoiceType::class, [
                'choices'  => array(
                    '0-30' => 1,
                    '30-50' => 2,
                    '50+' => 3,
                )
            ])
        ;
    }
}
