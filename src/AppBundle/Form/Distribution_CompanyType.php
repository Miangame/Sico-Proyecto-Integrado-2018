<?php

namespace AppBundle\Form;

use AppBundle\Entity\Distribution_company;
use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class Distribution_CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('user', ChoiceType::class,array(
                'choices' => $options["user"],
                'label' => 'Tutor',
                'data' => $options["user_selected"]
            ))
            ->add('company', ChoiceType::class,array(
                'choices' => $options["company"],
                'label' => 'Empresa',
                'data' => $options["company_selected"]
            ))
            ->add('student', ChoiceType::class,array(
                'choices' => $options["student"],
                'label' => 'Alumno',
                'data' => $options["student_selected"]
            ))
            ->add('save', SubmitType::class, array('label' => 'Enviar asignación','attr' => ['class' => 'btn waves-effect waves-light w-100']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Distribution_company::class,
            'user' => null,
            'student' => null,
            'company' => null,
            'user_selected' => null,
            'company_selected' => null,
            'student_selected' => null
        ]);
    }
}
