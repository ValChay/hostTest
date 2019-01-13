<?php

namespace App\Form;

use App\Entity\HostTable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HostTableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('address')
            ->add('address2')
            ->add('town')
            ->add('zipCode')
            ->add('description')
            ->add('priceRange')
            ->add('image', FileType::class, array('label' => 'Image (JPG file)', 'required' => false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HostTable::class,
        ]);
    }
}
