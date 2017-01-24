<?php

namespace AppBundle\EventDispatcher;

use AppBundle\Repository\SettingRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;
use Symfony\Component\Workflow\Event\GuardEvent;

/**
 * Class TaskDoneListener
 */
class TaskDoneListener
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var SettingRepository
     */
    private $settingsRepo;

    /**
     * TaskDoneListener constructor.
     *
     * @param \Swift_Mailer     $mailer
     * @param SettingRepository $settingsRepo
     */
    public function __construct(\Swift_Mailer $mailer, SettingRepository $settingsRepo)
    {
        $this->mailer = $mailer;
        $this->settingsRepo = $settingsRepo;
    }

    /**
     * @param Event $event
     */
    public function onTaskDone(Event $event)
    {
        $settings = $this->settingsRepo->getAll();
        $message = \Swift_Message::newInstance($settings['email_subject']);
        $message->setTo([$settings['to_email'] => 'Admin']);
        $message->setBody($settings['email_content']);

        $this->mailer->send($message);
    }
}
