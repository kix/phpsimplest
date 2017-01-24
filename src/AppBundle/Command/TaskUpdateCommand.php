<?php

namespace AppBundle\Command;

use AppBundle\Entity\Task;

/**
 * Class TaskUpdate
 */
class TaskUpdateCommand
{
    private $task;

    private $newTitle;

    private $transition;

    const NO_TRANSITION = false;

    /**
     * TaskUpdateCommand constructor.
     *
     * @param $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
        $this->newTitle = $task->getTitle();
    }

    /**
     * @return Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @return mixed
     */
    public function getNewTitle()
    {
        return $this->newTitle;
    }

    /**
     * @param mixed $newTitle
     */
    public function setNewTitle($newTitle)
    {
        $this->newTitle = $newTitle;
    }

    /**
     * @return mixed
     */
    public function getTransition()
    {
        return $this->transition;
    }

    /**
     * @param mixed $transition
     */
    public function setTransition($transition)
    {
        $this->transition = $transition;
    }
}
