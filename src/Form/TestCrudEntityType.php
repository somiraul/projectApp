<?php

namespace App\Form;

use App\Entity\TestCrudEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestCrudEntityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('column_1')
            ->add('column_2')
            ->add('column_3')
            ->add('column_4')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TestCrudEntity::class,
        ]);
    }
}
