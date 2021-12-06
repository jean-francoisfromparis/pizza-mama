<?php

namespace App\Form;

use App\Entity\Comments;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReplyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reply', TextareaType::class, [
                'label' => 'réponse',
                'row_attr' => [
                    'class' =>  'form-floating mb-3'
                ],
                'required' => true,
            ])
            ->add('email', TextType::class, [
                'label' => 'email',
                'row_attr' => [
                    'class' =>  'd-none'
                ],
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer la réponse'
            ]);

                $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                    $form = $event->getForm();
                    $comment = $event->getData();
                    // dd(!$comment->getSendAt());
                    if ($form->get('reply')->getData() && !$comment->getSendAt()) {
                        $comment->setSendAt(new \DateTimeImmutable());
                    }
                    $event->setData($comment);
                });
        ;
    }

    // public function configureOptions(OptionsResolver $resolver): void
    // {
    //     $resolver->setDefaults([
    //         'data_class' => Comments::class,
    //     ]);
    // }
}
