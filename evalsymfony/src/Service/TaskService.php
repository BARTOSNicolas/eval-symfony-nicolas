<?php

namespace App\Service;

use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Task;

class TaskService {
    public function __construct(
        private readonly TaskRepository $taskRepository,
        private readonly EntityManagerInterface $em
    ) {}

    public function addTask(Task $task): Task {
        try {
            // si pas de tâche
            if (!$task) {
                throw new \Exception('La tâche n\'existe pas' );
            }
            //Ajout de la date
            $task->setCreatedAt(new \DateTimeImmutable());
            // Status par default (au cas ou ...)
            $task->setStatus(false);
            // Ajout en BDD
            $this->em->persist($task);
            $this->em->flush();

            // Return la tâche
            return $task;

        } catch (\Exception $error) {
            throw new \Exception('Une erreur est surevnue pendant l\'ajout de la tâche' . $error);
        }
    }

    public function getAllTask(): array {
        try {
            return $this->taskRepository->findAll();
        } catch (\Exception $error) {
            throw new \Exception('Erreur quand on récupère les tâches : ' . $error);
        }
    }
}
