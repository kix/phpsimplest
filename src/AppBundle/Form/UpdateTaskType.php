<?php

namespace AppBundle\Form;

use AppBundle\Command\TaskUpdateCommand;
use AppBundle\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Workflow\StateMachine;
use Symfony\Component\Workflow\Transition;

/**
 * Class UpdateTaskType
 */
class UpdateTaskType extends AbstractType
{
    /**
     * @var StateMachine
     */
    private $stateMachine;

    /**
     * UpdateTaskType constructor.
     *
     * @param StateMachine $stateMachine
     */
    public function __construct(StateMachine $stateMachine)
    {
        $this->stateMachine = $stateMachine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newTitle', TextType::class)
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            $form = $event->getForm();
            /** @var Task $task */
            $task = $event->getData()->getTask();

            $transitions = array_map(function(Transition $transition) {
                return $transition->getName();
            }, $this->stateMachine->getEnabledTransitions($task));
            $transitions['No transition'] = false;

            $form->add('transition', ChoiceType::class, ['choices' => array_combine($transitions, $transitions)]);
        });
    }

}
