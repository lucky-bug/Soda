<?php

namespace App\Repositories;

use App\Models\Task;
use Soda\Core\Base;

class SessionTaskRepository extends Base implements TaskRepository
{
    public function getAll(): array
    {
        return getSession('tasks', []);
    }

    public function getById(string $id): ?Task
    {
        $tasks = $this->getAll();

        return $tasks[$id] ?? null;
    }

    public function insert(Task $task)
    {
        $tasks = $this->getAll();
        $tasks[$task->getId()] = $task;

        setSession('tasks', $tasks);
    }

    public function update(Task $task)
    {
        $tasks = $this->getAll();
        $tasks[$task->getId()] = $task;

        setSession('tasks', $tasks);
    }

    public function delete(Task $task)
    {
        $tasks = $this->getAll();
        unset($tasks[$task->getId()]);

        setSession('tasks', $tasks);
    }
}
