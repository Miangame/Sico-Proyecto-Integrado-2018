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
            ->add('initials', TextType::class, array('label' => 'Iniciales'))
            ->add('titularHours1', IntegerType::class, array(
                'label' => '1º Horas titulares/semana',
                'data' => $options['hTitular1'],
                'attr' => ['min' => 1]
            ))
            ->add('desdobleHours1', IntegerType::class, array(
                'label' => '1º Horas desdoble/semana',
                'data' => $options['hDesdoble1'],
                'attr' => ['min' => 1]
            ))
            ->add('titularHours2', IntegerType::class, array(
                'label' => '2º Horas titulares/semana',
                'data' => $options['hTitular2'],
                'attr' => ['min' => 1]
            ))
            ->add('desdobleHours2', IntegerType::class, array(
                'label' => '2º Horas desdoble/semana',
                'data' => $options['hDesdoble2'],
                'attr' => ['min' => 1]))
            ->add('save', SubmitType::class, array('label' => 'Aceptar', 'attr' => ['class' => 'w-100 waves-effect waves-light btn']));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cycle::class,
            'hTitular1' => null,
            'hDesdoble1' => null,
            'hTitular2' => null,
            'hDesdoble2' => null,
        ]);

    }
}