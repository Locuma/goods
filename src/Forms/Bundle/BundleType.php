<?php

namespace App\Forms\Bundle;

use App\Entity\Bundle;
use App\Entity\Goods;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BundleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['attr' => ['class' => "row justify-content-center"]])
            ->add('goods', EntityType::class, [
                'class' => Goods::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'name',
                'row_attr' => ['class' => 'one-good'],

            ])
            ->add('save', SubmitType::class, ['attr' => ['class' => "row justify-content-center"]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bundle::class,
        ]);
    }
}