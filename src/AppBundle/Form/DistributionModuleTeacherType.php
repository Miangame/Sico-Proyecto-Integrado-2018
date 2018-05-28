<?php


namespace AppBundle\Form;


use AppBundle\Entity\Distribution_module_teacher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DistributionModuleTeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('module', ChoiceType::class, array(
                'choices' => $options["modules"],
                'label' => 'Módulo',
                'data' => $options["module_selected"]
            ))
            ->add('teacher', ChoiceType::class, array(
                'choices' => $options["teachers"],
                'label' => 'Profesor',
                'data' => $options["teacher_selected"]
            ))
            ->add('group', ChoiceType::class, array(
                'choices' => $options["groups"],
                'label' => 'Grupo',
                'data' => $options["group_selected"]
            ))
            ->add('hours', IntegerType::class, array(
                'label' => 'Horas'
            ))
            ->add('schoolYear', ChoiceType::class, array(
                'choices' => $options["courses"],
                'label' => 'Curso',
                'data' => $options["course_selected"]
            ))
            ->add('save', SubmitType::class, array('label' => 'Enviar asignación', 'attr' => ['class' => 'btn waves-effect waves-light w-100']));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Distribution_module_teacher::class,
            'modules' => null,
            'module_selected' => null,
            'teachers' => null,
            'teacher_selected' => null,
            'groups' => null,
            'group_selected' => null,
            'courses' => null,
            'course_selected' => null
        ]);
    }
}