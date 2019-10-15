<?php

namespace App\Repositories;

use App\Models\Task;

interface TaskRepository
{
    public function getAll(): array;
    public function getById(int $id): ?Task;
    public function insert(Task $task);
    public function update(Task $task);
    public function deleteById(int $task);
}
