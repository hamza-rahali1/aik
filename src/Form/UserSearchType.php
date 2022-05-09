<?php

namespace App\Form;

use App\Entity\UserSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class UserSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('id', IntegerType::class ,[
            'label' => 'ID',
            'required' => false])
        ->add('keyWord', TextType::class,
            ['required' => false,
             'label' => 'PALABRA CLAVE',
             'attr' => ['placeholder' => 'Key Word']] )
        ->add('phone', TelType::class , [ 'required' => false,
             'label' => 'Teléfono'])
        ->add('fax', TelType::class , [ 'required' => false])
        ->add('roles', ChoiceType::class , [ 
            'required' => false,
            'label' => 'Ocupación',
            'placeholder' => '-Ocupación-',
            'choices'  => [
                'Client' => 'ROLE_USER',
                'Agent' => 'ROLE_AGENT',
                'Administrator' => 'ROLE_ADMIN'
            ],
            'required' => false ] )               
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserSearch::class,
            'method' => 'get',
            'csrf_protection' => false

        ]);
    }
}