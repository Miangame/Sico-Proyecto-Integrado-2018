<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 13/05/18
 * Time: 18:19
 */

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
                'choices' => $options["groups"]
                ))
            ->add('schoolYear_convocatory', ChoiceType::class, array(
                'label' => 'Convocatoria',
                'choices' => $options["convocatories"]
                ))
            ->add('save', SubmitType::class, array('label' => 'Enviar alumno','attr' => ['class' => 'w-100 waves-effect waves-light btn']));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
            'groups' => null,
            'convocatories' => null
        ]);

    }
}