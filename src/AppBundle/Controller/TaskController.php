<?php

namespace AppBundle\Controller;

use AppBundle\Command\TaskUpdateCommand;
use AppBundle\Entity\Task;
use AppBundle\Form\CreateTaskType;
use AppBundle\Form\UpdateTaskType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    const PER_PAGE = 5;

    /**
     * @Route("/", name="task_list")
     * @param Request $request
     * @return Response
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

    /**
     * @Route("/create", name="task_create")
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(CreateTaskType::class);

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $task = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($task);
                $em->flush();

                return $this->redirectToRoute('task_list');
            }
        }

        return $this->render('task/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="task_edit")
     * @param Task    $task
     * @param Request $request
     * @return Response
     */
    public function editAction(Task $task, Request $request)
    {
        $form = $this->createForm(UpdateTaskType::class, new TaskUpdateCommand($task));

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $handler = $this->get('app.command.handler.task_update');
                $handler->handle($form->getData());

                return $this->redirectToRoute('task_list');
            }
        }

        return $this->render('task/form.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/export", name="task_export")
     * @return Response
     */
    public function exportAction()
    {
        $tasks = $this->getDoctrine()->getRepository(Task::class)->findAll();
        $serializer = $this->get('serializer');

        return new Response($serializer->serialize($tasks, 'json'), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/archive/{id}", name="task_archive")
     * @param Task $task
     * @return Response
     */
    public function archiveAction(Task $task)
    {
        $task->archive();

        $em = $this->getDoctrine()->getManager();
        $em->persist($task);
        $em->flush();

        return $this->redirectToRoute('task_list');
    }
}
