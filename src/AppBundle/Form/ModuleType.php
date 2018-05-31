<?php

namespace AppBundle\Form;


use AppBundle\Entity\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', TextType::class, array('label' => 'Nombre'))
            ->add('initials', TextType::class, array('label' => 'Iniciales'))
            ->add('hours', IntegerType::class, array('label' => 'Horas'))
            ->add('hoursDesdoble', IntegerType::class, array('label' => 'Horas desdoble'))
            ->add('cycle', ChoiceType::class, array(
                'label' => "Ciclo",
                'choices' => $options['cycles'],
                'data' => $options['cycle_selected']
            ))
            ->add('group', ChoiceType::class, array(
                'label' => "Grupo",
                'choices' => $options["groups"],
                'data' => $options["group_selected"]
            ))
            ->add('save', SubmitType::class, array('label' => 'Enviar módulo', 'attr' => ['class' => 'w-100 waves-effect waves-light btn']));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
            'cycles' => null,
            'groups' => null,
            'cycle_selected' => null,
            'group_selected' => null
        ]);

    }
}