<?php

namespace App\Controllers;

use App\Models\Task;
use App\Repositories\SessionTaskRepository;
use App\Repositories\TaskRepository;
use Soda\Controller\WebController;
use Soda\Http\RedirectResponse;
use Soda\Http\Response;
use Soda\Pagination\Pagination;

class TasksController extends WebController
{
    protected $repository;

    public function __construct($options = [], TaskRepository $taskRepository = null)
    {
        parent::__construct($options);
        $this->repository = $taskRepository == null ? new SessionTaskRepository() : $taskRepository;
    }

    public function index()
    {
        $tasks = $this->repository->getAll();
        $sortField = $this->request->get('sortBy', getSession('tasks_sort_by', 'name'));
        $pageLimit = $this->request->get('limit', getSession('tasks_page_limit', 3));
        
        usort($tasks, function(Task $task1, Task $task2) use($sortField) {
            return strcmp($task1->$sortField, $task2->$sortField);
        });

        $page = max(1, min($this->request->get('page', 1), (int)((count($tasks) + $pageLimit - 1) / $pageLimit)));

        $pagination = new Pagination([
            'data' => $tasks,
            'page' => $page,
            'pageLimit' => $pageLimit,
        ]);

        setSession('tasks_page_limit', $pageLimit);
        setSession('tasks_sort_by', $sortField);

        return new Response(
            resolve('viewEngine')->render(
                'tasks.index',
                [
                    'tasks' => $pagination->getCurrentPage(),
                    'page' => $pagination->getPage(),
                ]
            )
        );
    }

    public function create()
    {
        $task = new Task([
            'id' => random_bytes(32),
            'name' => $this->request->get('name'),
            'email' => $this->request->get('email'),
            'text' => $this->request->get('text'),
        ]);

        $this->repository->insert($task);

        return new RedirectResponse('/tasks/index');
    }
}
