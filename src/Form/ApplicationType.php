<?php

namespace App\Form;

use App\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];

        
            

        if  ($user) {
            $builder
            ->add('address', TextType::class , [ 'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Address (optional)',
                            ]])
            ->add('type' , ChoiceType::class ,[
                'label' => false,
                'placeholder' => '-Applying for-',
                'choices'  => [
                    'Buy' => 'buy' ,
                    'Rent' => 'rent' ,
                    'Sell' => 'sell',
                    'Properties Management' => 'pm' ,
                    'Contracts Management' => 'cm' ,
                    'Consultancy' => 'consult',
                    'Other' => 'other',

                ],
                'required' => false,
                'empty_data' => 'other'] )
            ->add('content', TextareaType::class , [
                    'required' => false ,
                    'label' => false]);}
            
        else{
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
            ->add('content', TextareaType::class , [
                'required' => false ,
                'label' => false])
            ->add('otherEmail', EmailType::class , [ 'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Your second Email address'
                            ]])
            ->add('address', TextType::class , [ 'label' => false,
                'attr' => ['placeholder' => 'Address (optional)',
                            ]])
            ->add('type' ,ChoiceType::class ,[
                'label' => false,
                'placeholder' => '-Applying for-',
                'choices'  => [
                    'Buy' => 'buy' ,
                    'Rent' => 'rent' ,
                    'Sell' => 'sell',
                    'Properties Management' => 'pm' ,
                    'Contracts Management' => 'cm' ,
                    'Consultancy' => 'consult',
                    'Other' => 'other',

                ],
                'required' => false,
                'empty_data' => 'other'] )
        ;
            } 
    } 

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
            'user' => null,
        ]);
    }
}
