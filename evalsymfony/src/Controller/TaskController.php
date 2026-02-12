<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class TaskController extends AbstractController
{
    public function __construct(
        private readonly TaskService $taskService
    ) {}

    #[Route('/task/all', name: 'app_task_all', methods: ['GET'])]
    public function getAllTask(): Response
    {
        try {
            $tasks = $this->taskService->getAllTask();
        } catch (\Exception $error) {
            $this->addFlash('danger', $error->getMessage());
            $tasks = [];
        }

        return $this->render('task/showTasks.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/task/add', name: 'app_task_add', methods: ['GET', 'POST'])]
    public function addNewTask(Request $request): Response
    {
        // Nouvelle Task
        $task = new Task();
        // Formulaire
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        // Si formulaire valider et soumis
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->taskService->addTask($task);
                $this->addFlash('success', 'Votre tâche est maintenant ajoutée');
                return $this->redirectToRoute('app_task_all');
            } catch (\Exception $error) {
                $this->addFlash('danger', 'Une erreur est survenue : ' . $error);
            }
        }

        return $this->render('task/addTask.html.twig', [
            'form' => $form
        ]);
    }
}
