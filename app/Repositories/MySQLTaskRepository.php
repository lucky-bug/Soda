<?php

namespace App\Repositories;

use App\Models\Task;
use Soda\Core\Base;
use Soda\Database\Connector\MySQLConnector;

class MySQLTaskRepository extends Base implements TaskRepository
{
    /**
     * @getter
     * @setter
     * @var MySQLConnector
     */
    protected $connector;

    public function getAll(): array
    {
        $data = [];
        $result = $this->connector->execute('SELECT * FROM tasks');

        while ($row = $result->fetch_assoc()) {
            $data[] = new Task($row);
        }

        return $data;
    }

    public function getById(int $id): ?Task
    {
        $task = null;
        $result = $this->connector->execute(
            sprintf("SELECT * FROM tasks where id = %d", $this->connector->escape($id))
        );

        if ($row = $result->fetch_assoc()) {
            $task = new Task($row);
        }

        return $task;
    }

    public function insert(Task $task)
    {
        $result = $this->connector->execute(
            sprintf(
                "INSERT INTO tasks(name, email, text, status, edited) VALUES('%s', '%s', '%s', %d, %d)",
                $this->connector->escape($task->name),
                $this->connector->escape($task->email),
                $this->connector->escape($task->text),
                $this->connector->escape($task->status),
                $this->connector->escape($task->edited)
            )
        );
    }

    public function update(Task $task)
    {
        $result = $this->connector->execute(
            sprintf(
                "UPDATE tasks SET name = '%s', email = '%s', text = '%s', status = %d, edited = %d where id = %d",
                $this->connector->escape($task->name),
                $this->connector->escape($task->email),
                $this->connector->escape($task->text),
                $this->connector->escape($task->status),
                $this->connector->escape($task->edited),
                $this->connector->escape($task->id)
            )
        );
    }

    public function deleteById(int $id)
    {
        $result = $this->connector->execute(
            sprintf(
                "DELETE FROM tasks where id = %d",
                $id
            )
        );

        return $result;
    }
}
