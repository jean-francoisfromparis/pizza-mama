<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrderType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add('pseudo', TextType::class, [
                'required' => true,
                // 'mapped' => false,
                'label' => false,
                'constraints' => [new NotBlank(), new Length(['min' => 2])],
            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'mapped' => false,
                'label' => false,
                // 'data' => 'email@email.com', for test purpose
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
            ]);
    }
}
