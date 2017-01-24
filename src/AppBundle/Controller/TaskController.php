<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends Controller
{
    const PER_PAGE = 5;

    /**
     * @Route("/", name="task_list")
     */
    public function indexAction(Request $request)
    {
        $archived = $request->query->getBoolean('archived');
        $taskRepo = $this->getDoctrine()->getRepository(Task::class);
        $currentPage = $request->query->get('page', 1);

        $result = [
            'taskGroups' => $taskRepo->findGrouped(
                $archived,
                $archived ? self::PER_PAGE : false,
                $archived ? ($currentPage - 1) * self::PER_PAGE : false
            ),
            'archived' => $archived,
        ];

        if ($archived) {
            $result['currentPage'] = $currentPage;
            $result['totalPages'] = $taskRepo->countArchived() / self::PER_PAGE;
        }

        return $this->render('task/list.html.twig', $result);
    }
}
