<?php

namespace AppBundle\Form;


use AppBundle\Entity\Configuration;
use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigWebType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('weight_pi', NumberType::class, array(
                'label' => 'Peso PI',
            ))
            ->add('weight_fct', NumberType::class, array(
                'label' => 'Peso FCT',
            ))
            ->add('hours_first', CheckboxType::class, array(
                'label' => 'Usar horas de primero',
            ))
            ->add('hours_secondary', CheckboxType::class, array(
                'label' => 'Usar horas de segundo',
            ))
            ->add('save', SubmitType::class, array('label' => 'Aplicar', 'attr' => ['class' => 'waves-effect waves-light btn']));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Configuration::class
        ]);

    }
}