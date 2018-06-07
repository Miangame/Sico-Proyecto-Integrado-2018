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

class TeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('username', TextType::class, array(
                'label' => 'Usuario',
                'constraints' => array(
                    new NotBlank()
                )))
            ->add('first_name', TextType::class, array('label' => 'Nombre'))
            ->add('last_name', TextType::class, array('label' => 'Apellidos'))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'constraints' => array(
                    new NotBlank()
                )))
            ->add('img', FileType::class, array(
                'label' => 'Foto',
                'attr' => ['class' => 'file-field input-field', 'accept' => 'image/*']
            ))
            ->add('plainPassword', PasswordType::class, array(
                'label' => 'Contraseña',
                'constraints' => array(
                    new NotBlank(),
                    new Regex(array(
                        'pattern' => '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,}$/',
                        'message' => 'Debe contener al menos una mayúscula, una minúscula, un número y 5 carácteres.',
                    ))
                )
            ))
            ->add('save', SubmitType::class, array('label' => 'Aceptar', 'attr' => ['class' => 'w-100 waves-effect waves-light btn']));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);

    }
}