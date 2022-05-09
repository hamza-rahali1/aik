<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', CKEditorType::class)
            ->add('situation', ChoiceType::class, 
            [ 'choices' => $this->getChoicesSitu() ])
            ->add('state' , ChoiceType::class, 
            [ 'choices' => $this->getChoicesState() ])
            ->add('type', ChoiceType::class, 
            [ 'choices' => $this->getChoicesType() ])
            ->add('rooms')
            ->add('bedrooms')
            ->add('bathrooms')
            ->add('parking')
            ->add('price')
            ->add('floors')
            ->add('address')
            ->add('city')
            ->add('video')
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)
            ->add('space')
            ->add('cooling')
            ->add('heating')
            ->add('images', FileType::class , [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }

    private function getChoicesSitu()
    {
        $choices = Property::SITUATION;
        $output = [];
        foreach($choices as $k => $v)
        {
            $output[$v] = $k;
        }
        return $output;
    }
    private function getChoicesType()
    {
        $choices = Property::TYPE;
        $output = [];
        foreach($choices as $k => $v)
        {
            $output[$v] = $k;
        }
        return $output;
    }
    private function getChoicesState()
    {
        $choices = Property::STATES;
        $output = [];
        foreach($choices as $k => $v)
        {
            $output[$v] = $k;
        }
        return $output;
    }
}
