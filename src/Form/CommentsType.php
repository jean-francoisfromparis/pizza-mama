<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Comments;
use App\Repository\ProductRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'votre email',
                'row_attr' => [
                    'class' =>  'form-floating my-3'
                ],
                'required' => true,
            ])
            ->add('pseudo', TextType::class, [
                'label' => 'votre pseudo',
                'row_attr' => [
                    'class' =>  'form-floating mb-3'
                ],
                'required' => true,
            ])
            ->add('content', TextareaType::class, [
                'label' => 'votre commentaire',
                'row_attr' => [
                    'class' =>  'form-floating mb-3'
                ],
                'required' => true,
            ])
            ->add('compliance', CheckboxType::class, [
                'label' => false,
                'required' => true,
            ])
            // ->add('products', EntityType::class, [
            //     'class' => Product::class,
            //     'query_builder' => function (ProductRepository $products) {
            //         return $products->createQueryBuilder('p')
            //             ->orderBy('p.category', 'ASC');
            //     },
            //     'choice_label' => 'name',
            //     'label' => false,
            //     'expanded' => true,
            //     // 'multiple' => true,
            //     'required' => true,
            // ])
            ->add('parentid', HiddenType::class, [
                'mapped' => false
            ])
            ->add('send', SubmitType::class, [
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
