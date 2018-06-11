<?php


namespace AppBundle\Form;


use AppBundle\Entity\EventCalendar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventCalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('module', ChoiceType::class, array(
                'label' => 'Módulo',
                'choices' => $options["modules"],
                'data' => $options["module_selected"]
            ))
            ->add('weekDay', ChoiceType::class, array(
                'label' => 'Día',
                'choices' => [
                    "Lunes" => "monday",
                    "Martes" => "tuesday",
                    "Miércoles" => "wednesday",
                    "Jueves" => "thursday",
                    "Viernes" => "friday"
                ],
                'data' => $options["day_selected"]
            ))
            ->add('init_hour', TimeType::class, array(
                'label' => 'Hora inicial',
                'data' => $options['initialHour']
            ))
            ->add('final_hour', TimeType::class, array(
                'label' => 'Hora final',
                'data' => $options['finalHour']
            ))
            ->add('gr', ChoiceType::class, array(
                'label' => 'Grupo',
                'choices' => $options["groups"],
                'data' => $options['group_selected']
            ))
            ->add('color', ColorType::class, array(
                'label' => 'Color',
                'data' => $options['color_selected']
            ))
            ->add('save', SubmitType::class, array('label' => 'Aceptar', 'attr' => ['class' => 'w-100 waves-effect waves-light btn']));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventCalendar::class,
            'modules' => null,
            'module_selected' => null,
            'initialHour' => null,
            'initialHour_selected' => null,
            'finalHour' => null,
            'finalHour_selected' => null,
            'day_selected' => null,
            'color_selected' => null,
            'groups' => null,
            'group_selected' => null
        ]);

    }
}