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
            ->add('course', ChoiceType::class, array(
                'label' => 'Curso',
                'choices' => array(
                    1 => 1,
                    2 => 2)
            ))
            ->add('gr', ChoiceType::class, array(
                'label' => 'Grupo',
                'choices' => array(
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C')
            ))
            ->add('cycle', ChoiceType::class, array(
                    'label' => "Ciclo",
                    'choices' => $options["cycles"]
                )
            )
            ->add('save', SubmitType::class, array('label' => 'Enviar grupo', 'attr' => ['class' => 'w-100 waves-effect waves-light btn']));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => School_group::class,
            'cycles' => null,
            'cycle_selected' => null,
        ]);

    }
}