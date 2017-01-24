<?php

namespace AppBundle\Form;

use AppBundle\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CreateTaskType
 */
class CreateTaskType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', Task::class);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $supportedStatuses = Task::getSupportedStatuses();
        $builder
            ->add('title', TextType::class)
            ->add('status', ChoiceType::class, [
                'choices' => array_combine($supportedStatuses, $supportedStatuses)
            ])
        ;
    }
}
