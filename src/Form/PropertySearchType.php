<?php

namespace App\Form;

use App\Entity\PropertySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('propertyId', IntegerType::class ,[
                'label' => 'ID',
                'required' => false])
            ->add('situationS', ChoiceType::class, 
            [ 'choices' => $this->getChoicesSitu(),
              'placeholder' => '-SITUACION-',
              'label' => 'SITUACION', 
              'required' => false])
            ->add('typeS', ChoiceType::class, 
            [ 'choices' => $this->getChoicesType() ,
            'placeholder' => '-TIPO-',
            'label' => 'TIPO', 
            'required' => false])
            ->add('stateS' , ChoiceType::class, 
            [ 'choices' => $this->getChoicesState() ,
            'placeholder' => '-ESTADO-',
            'label' => 'ESTADO', 
            'required' => false])
            ->add('minSpace', IntegerType::class, [
                'label' => 'MÍNIMO SUPERFICIE', 
                'required' => false])
            ->add('minRooms', IntegerType::class ,[
                'label' => 'MÍNIMO HABITACIONES',
                'required' => false] )
            ->add('minBedrooms', IntegerType::class ,[
                'label' => 'MÍNIMO RECAMARAS',
                'required' => false] )
            ->add('maxPrice', IntegerType::class ,[
                'label' => 'MÁXIMO PRECIO',
                'required' => false] )
            ->add('lat', HiddenType::class ,[
                'required' => false] )
            ->add('lng', HiddenType::class ,[
                'required' => false] )
            ->add('distance', ChoiceType::class ,[
                'placeholder' => '-DISTANCIA-',
                'choices'  => [
                    '5 km' => 5 ,
                    '10 km' => 10 ,
                    '25 km' => 25 ,
                    '50 km' => 50 ,
                    '100 km' => 100 ,
                    '500 km' => 500,
                    '1000 km' => 1000,
                ],
                'required' => false,
                'empty_data' => '500'] )
            ->add('titleS', TextType::class,
            ['required' => false,
             'label' => 'PALABRA CLAVE',
             'attr' => ['placeholder' => 'PALABRA CLAVE']] )

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => 'get',
            'csrf_protection' => false

        ]);
    }

    private function getChoicesSitu()
    {
        $choices = PropertySearch::SITUATION;
        $output = [];
        foreach($choices as $k => $v)
        {
            $output[$v] = $k;
        }
        return $output;
    }
    private function getChoicesType()
    {
        $choices = PropertySearch::TYPE;
        $output = [];
        foreach($choices as $k => $v)
        {
            $output[$v] = $k;
        }
        return $output;
    }
    private function getChoicesState()
    {
        $choices = PropertySearch::STATES;
        $output = [];
        foreach($choices as $k => $v)
        {
            $output[$v] = $k;
        }
        return $output;
    }

    public function getBlockPrefix()
    {
        return '' ;
    }
}
