<?php

namespace App\Forms\Goods;

use App\Entity\Goods;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GoodsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,['attr' => ['class'=> "row justify-content-center"]])
            ->add('price', IntegerType::class,['attr' => ['class'=> "row justify-content-center"]])
            ->add('save', SubmitType::class,['attr' => ['class'=> "row justify-content-center"]]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Goods::class,
        ]);
    }
}