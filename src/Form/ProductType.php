<?php

namespace App\Form;


use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', null, ['required' => true, 'attr' => ['min' => 4, 'max' => 10]])
            ->add('name', null, ['required' => true, 'attr' => ['min' => 4]])
            ->add('description', TextareaType::class, ['required' => true])
            ->add('brand', null, ['required' => true])
            ->add('price', MoneyType::class, ['required' => true])
            ->add('category', EntityType::class, array(
                'required' => true,
                'placeholder' => 'Seleccione una categoria...',
                'class' => Category::class,
                'choice_label' => 'name'
            ))
            ->add('Guardar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
