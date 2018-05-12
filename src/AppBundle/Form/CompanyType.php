<?php

namespace AppBundle\Form;

use AppBundle\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Nombre'))
            ->add('cif', TextType::class, array('label' => 'CIF'))
            ->add('phone', TextType::class, array('label' => 'Teléfono'))
            ->add('email', TextType::class, array('label' => 'Email'))
            ->add('save', SubmitType::class, array('label' => 'Enviar empresa','attr' => ['class' => 'btn waves-effect waves-light w-100']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
