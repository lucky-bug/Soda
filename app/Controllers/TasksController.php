<?php

namespace App\Controllers;

use App\Models\Task;
use App\Repositories\MySQLTaskRepository;
use App\Repositories\TaskRepository;
use Soda\Controller\WebController;
use Soda\Database\Connector\MySQLConnector;
use Soda\Http\RedirectResponse;
use Soda\Http\Response;
use Soda\Pagination\Pagination;

class TasksController extends WebController
{
    protected $repository;

    public function __construct($options = [], TaskRepository $taskRepository = null)
    {
        parent::__construct($options);
        $connector = new MySQLConnector();
        $connector->initialize();

        $this->repository = $taskRepository == null
            ? new MySQLTaskRepository(['connector' => $connector])
            : $taskRepository
        ;
    }

    public function index()
    {
        $tasks = $this->repository->getAll();
        $sortField = $this->request->get('sortBy', 'name');
        $sortOrder = $this->request->get('order', 'asc');
        $pageLimit = $this->request->get('limit', 3);
        
        usort($tasks, function(Task $task1, Task $task2) use($sortField, $sortOrder) {
            if ($sortOrder == 'asc') {
                return strcmp($task1->$sortField, $task2->$sortField);
            }

            return strcmp($task2->$sortField, $task1->$sortField);
        });

        $page = max(1, min($this->request->get('page', 1), (int)((count($tasks) + $pageLimit - 1) / $pageLimit)));

        $pagination = new Pagination([
            'data' => $tasks,
            'page' => $page,
            'pageLimit' => $pageLimit,
        ]);

        return new Response(
            resolve('viewEngine')->render(
                'tasks.index',
                [
                    'tasks' => $pagination->getCurrentPage(),
                    'page' => $pagination->getPage(),
                    'hasPrevPage' => $pagination->hasPrev(),
                    'hasNextPage' => $pagination->hasNext(),
                ]
            )
        );
    }

    public function getCreate()
    {
        return new Response(
            resolve('viewEngine')->render(
                'tasks.create'
            )
        );
    }

    public function create()
    {
        $valid = $this->request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'text' => 'required|string',
        ]);

        if ($valid) {
            $validData = $this->request->validator->validFields;
            $task = new Task([
                'name' => $validData['name'],
                'email' => $validData['email'],
                'text' => $validData['text'],
            ]);

            $this->repository->insert($task);

            return new RedirectResponse('/tasks/index');
        }

        return new Response(
            resolve('viewEngine')->render(
                'tasks.create',
                [
                    'errors' => $this->request->validator->errors,
                    'old' => $this->request->validator->fields,
                ]
            )
        );
    }

    public function delete()
    {
        if (authenticated()) {
            $result = $this->repository->deleteById($this->request->get('id'));
        }

        return new RedirectResponse('/tasks/index');
    }

    public function edit()
    {
        if (authenticated()) {
            $task = $this->repository->getById($this->parameters['id']);

            return new Response(
                resolve('viewEngine')->render(
                    'tasks.edit',
                    ['task' => $task]
                )
            );
        }

        return new RedirectResponse('/tasks/index');
    }

    public function postEdit()
    {
        if (authenticated()) {
            $task = $this->repository->getById($this->parameters[0]);

            if ($task) {
                $valid = $this->request->validate([
                    'text' => 'required|string',
                    'status' => 'required|bool',
                ]);

                if ($valid) {
                    $validData = $this->request->validator->validFields;

                    $task->setEdited($task->getEdited() || $task->getText() != $validData['text']);
                    $task->setText($validData['text']);
                    $task->setStatus((bool)$validData['status']);
                    $this->repository->update($task);
                } else {
                    return new Response(
                        resolve('viewEngine')->render(
                            'tasks.edit',
                            [
                                'task' => $task,
                                'errors' => $this->request->validator->errors,
                            ]
                        )
                    );
                }
            }
        }

        return new RedirectResponse('/tasks/index');
    }
}
