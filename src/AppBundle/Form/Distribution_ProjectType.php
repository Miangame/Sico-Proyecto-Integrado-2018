<?php

namespace AppBundle\Form;

use AppBundle\Entity\Distribution_project;
use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class Distribution_ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('user', ChoiceType::class,array(
                'choices' => $options["user"],
                'label' => 'Tutor',
                'data' => $options["user_selected"]
            ))
            ->add('project', ChoiceType::class,array(
                'choices' => $options["project"],
                'label' => 'Proyecto',
                'data' => $options["project_selected"]
            ))
            ->add('student', ChoiceType::class,array(
                'choices' => $options["student"],
                'label' => 'Alumno',
                'data' => $options["student_selected"]
            ))
            ->add('save', SubmitType::class, array('label' => 'Aceptar','attr' => ['class' => 'btn waves-effect waves-light w-100']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Distribution_project::class,
            'user' => null,
            'student' => null,
            'project' => null,
            'user_selected' => null,
            'project_selected' => null,
            'student_selected' => null
        ]);
    }
}
