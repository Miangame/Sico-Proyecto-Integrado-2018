<?php


namespace AppBundle\Form;


use AppBundle\Entity\School_group;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('course_cycle', ChoiceType::class, array(
                'label' => 'Curso',
                'choices' => $options["courses_cycles"],
                'data' => $options["courses_cycles_selected"]
            ))
            ->add('gr', ChoiceType::class, array(
                'label' => 'Grupo',
                'choices' => array(
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C'),
                'data' => $options['group_selected']
            ))
            ->add('save', SubmitType::class, array('label' => 'Aceptar', 'attr' => ['class' => 'w-100 waves-effect waves-light btn']));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => School_group::class,
            'cycles' => null,
            'cycle_selected' => null,
            'courses_cycles' => null,
            'courses_cycles_selected' => null,
            'group_selected' => null,
        ]);

    }
}