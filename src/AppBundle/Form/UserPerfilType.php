<?php

namespace AppBundle\Form;


use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserPerfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('first_name', TextType::class, array('label' => 'Nombre'))
            ->add('last_name', TextType::class, array('label' => 'Apellidos'))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'constraints' => array(
                    new NotBlank(),
                    new Regex(array(
                        'pattern' => '/([\w\.\-_]+)?\w+@[\w-_]+(\.\w+){1,}/',
                        'message' => 'El correo debe disponer de un formato correcto.',
                    ))
                )))
            ->add('save', SubmitType::class, array('label' => 'Guardar', 'attr' => ['class' => 'w-100 waves-effect waves-light btn']));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);

    }
}