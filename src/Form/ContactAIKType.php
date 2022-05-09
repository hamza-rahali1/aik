<?php

namespace App\Form;

use App\Entity\ContactAIK;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ContactAIKType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class , [ 'label' => false,
                'attr' => ['placeholder' => 'Your Email address'
                        ]])
            ->add('phone', TelType::class , [
                            'label' => false])
            ->add('address', TextType::class , [ 'label' => false,
            'attr' => ['placeholder' => 'Your agency address',
                        ]])
            ->add('facebook', TextType::class , [ 'label' => false,

                'attr' => ['placeholder' => 'https://facebook.com/profile',
                            ]])
            ->add('instagram', TextType::class , [ 'label' => false,
            'attr' => ['placeholder' => 'https://instagram.com/profile',
                        ]])
            ->add('twitter', TextType::class , [ 'label' => false,
            'attr' => ['placeholder' => 'https://twitter.com/profile',
                        ]])
            ->add('linkedin', TextType::class , [ 'label' => false,

                'attr' => ['placeholder' => 'https://linkedin.com/profile',
                            ]])
            ->add('generalDescri', CKEditorType::class , [ 'label' => false,
            ])
            ->add('sellDescri', CKEditorType::class , [ 'label' => false,
            ])
            ->add('gestionDescri', CKEditorType::class , [ 'label' => false,
            ])
            ->add('contratDescri', CKEditorType::class , [ 'label' => false,
            ])
            ->add('consultDescri', CKEditorType::class , [ 'label' => false,
            ])
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactAIK::class,
        ]);
    }
}
