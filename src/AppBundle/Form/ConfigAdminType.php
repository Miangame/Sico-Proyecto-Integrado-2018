<?php


namespace AppBundle\Form;


use AppBundle\Entity\Configuration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('organization_name', TextType::class, array(
                'label' => false,
            ))
            ->add('save', SubmitType::class, array('label' => 'Aplicar', 'attr' => ['class' => 'waves-effect waves-light btn mt-2']));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Configuration::class
        ]);

    }
}