<?php

namespace AppBundle\Form;


use AppBundle\Entity\Student;
use AppBundle\Services\StudentsHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('first_name', TextType::class, array('label' => 'Nombre'))
            ->add('last_name', TextType::class, array('label' => 'Apellidos'))
            ->add('group', ChoiceType::class, array(
                'label' => "Grupo",
                'choices' => $options["groups"],
                'data' => $options["group_selected"]
                ))
            ->add('convocatory', ChoiceType::class, array(
                'label' => 'Convocatoria',
                'choices' => $options["convocatories"],
                'data' => $options["convocatory_selected"]
                ))
            ->add('save', SubmitType::class, array('label' => 'Aceptar','attr' => ['class' => 'w-100 waves-effect waves-light btn']));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
            'groups' => null,
            'group_selected' => null,
            'convocatories' => null,
            'convocatory_selected' => null
        ]);

    }
}