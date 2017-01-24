<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table(name="tasks")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaskRepository")
 */
class Task
{
    const STATUS_TODO = 'todo';

    const STATUS_IN_PROGRESS = 'in_progress';

    const STATUS_REVIEW = 'review';

    const STATUS_DONE = 'done';

    private static $supportedStatuses = [
        self::STATUS_TODO,
        self::STATUS_IN_PROGRESS,
        self::STATUS_REVIEW,
        self::STATUS_DONE,
    ];

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, columnDefinition="ENUM('todo', 'in_progress', 'review', 'done')")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="archive_at", type="datetime", nullable=true)
     */
    private $archivedAt;

    /**
     * Task constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return array
     */
    public static function getSupportedStatuses()
    {
        return self::$supportedStatuses;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Task
     */
    public function setStatus($status)
    {
        if (!in_array($status, self::$supportedStatuses)) {
            throw new \InvalidArgumentException(sprintf(
                'Status `%s` is not supported. Use one of: %s',
                $status,
                implode(', ', self::$supportedStatuses)
            ));
        }

        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Task
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Archive the task
     *
     * @return Task
     */
    public function archive()
    {
        $this->archivedAt = new \DateTime('now');
    }

    /**
     * Get archivedAt
     *
     * @return string
     */
    public function getArchivedAt()
    {
        return $this->archivedAt;
    }
}

