<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];

        $builder
            ->add('firstName', TextType::class , [ 'label' => false,
            'attr' => ['placeholder' => 'Your first name...',
                        ]])
            ->add('lastName', TextType::class , [ 'label' => false,
                'attr' => ['placeholder' => 'Your last name...',
                            ]])
            ->add('email', EmailType::class , [ 'label' => false,
                'attr' => ['placeholder' => 'Your Email address'
                            ]])
            ->add('phone', TelType::class , [
                'label' => false])
            ->add('description', TextareaType::class , [
                'required' => false ,
                'label' => false])
            ->add('hash', PasswordType::class , [ 'label' => false ,
                'attr' => ['placeholder' => 'Choice your password']])
            ->add('passwordcomfirm', PasswordType::class , [ 'label' => false ,
                'attr' => ['placeholder' => 'Password Confirmation']])
            ->add('fax', TelType::class , [ 'required' => false,
                'label' => false])
             ->add('facebook', TextType::class , [ 'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'https://facebook.com/profile',
                            ]])
            ->add('linkedin', TextType::class , [ 'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'https://linkedin.com/profile',
                            ]])
            ->add('website', TextType::class , [ 'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'www.your-website.com',
                            ]])
            ->add('otherEmail', EmailType::class , [ 'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Your second Email address'
                            ]]);
            if ( ($user) && ($user->getRole() == 'ROLE_ADMIN')){
                $builder ->add('role', ChoiceType::class , [ 'placeholder' => '-Role-',
                    'choices'  => [
                        'Client' => 'ROLE_USER',
                        'Agent' => 'ROLE_AGENT',
                        'Administrator' => 'ROLE_ADMIN'
                    ],
                    'required' => false,
                    'empty_data' => 'ROLE_USER'] ); }
            else{
                $builder ->add('role', HiddenType::class , [
                    'empty_data' => 'ROLE_USER'] ); 
            }
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'user' => null,
        ]);
    }
}
