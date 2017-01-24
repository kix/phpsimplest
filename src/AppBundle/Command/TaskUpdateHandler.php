<?php

namespace AppBundle\Command;

use AppBundle\Entity\Task;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Workflow\StateMachine;

/**
 * Class TaskUpdateHandler
 */
class TaskUpdateHandler
{
    /**
     * @var StateMachine
     */
    private $stateMachine;

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * TaskUpdateHandler constructor.
     *
     * @param StateMachine  $stateMachine
     * @param ObjectManager $em
     */
    public function __construct(StateMachine $stateMachine, ObjectManager $em)
    {
        $this->stateMachine = $stateMachine;
        $this->em = $em;
    }

    public function handle(TaskUpdateCommand $command)
    {
        $task = $command->getTask();

        if ($command->getNewTitle()) {
            $task->setTitle($command->getNewTitle());
        }

        if ($command->getTransition() !== false) {
            $this->stateMachine->apply($task, $command->getTransition());
        }

        $this->em->persist($task);
        $this->em->flush();
    }
}
