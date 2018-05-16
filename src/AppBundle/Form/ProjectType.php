<?php

namespace AppBundle\Form;

use AppBundle\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Nombre'))
            ->add('description', TextareaType::class, array('label' => 'Descripción','attr'=> ['class' => 'materialize-textarea']))
            ->add('required_students', IntegerType::class, array('label' => 'Alumnos requieridos','attr' => ['min' => '1', 'max' => '9']))
            ->add('save', SubmitType::class, array('label' => 'Enviar proyecto','attr' => ['class' => 'btn waves-effect waves-light w-100']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
