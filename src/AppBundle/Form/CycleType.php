<?php


namespace AppBundle\Form;


use AppBundle\Entity\Cycle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CycleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', TextType::class, array('label' => 'Nombre'))
            ->add('titularHours1', IntegerType::class, array('label' => '1º Horas titulares/semana', 'attr' => ['min' => 1]))
            ->add('desdobleHours1', IntegerType::class, array('label' => '1º Horas desdoble/semana', 'attr' => ['min' => 1]))
            ->add('titularHours2', IntegerType::class, array('label' => '2º Horas titulares/semana', 'attr' => ['min' => 1]))
            ->add('desdobleHours2', IntegerType::class, array('label' => '2º Horas desdoble/semana', 'attr' => ['min' => 1]))
            ->add('save', SubmitType::class, array('label' => 'Enviar ciclo', 'attr' => ['class' => 'w-100 waves-effect waves-light btn']));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cycle::class
        ]);

    }
}