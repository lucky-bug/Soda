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

    public function getById(int $id): ?Task
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

    public function deleteById(int $id)
    {
        $tasks = $this->getAll();
        unset($tasks[$id]);

        setSession('tasks', $tasks);
    }
}
