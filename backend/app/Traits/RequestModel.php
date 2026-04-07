<?php

namespace App\Traits;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait RequestModel
{
    public $entities = [
        'task' => [
            'request' => TaskRequest::class,
            'model' => Task::class
        ]
    ];

    public function getRequest(string $entity): string
    {
        return $this->entities[$entity]['request'] ?? throw new NotFoundHttpException('Request "' . $entity . '" not found');
    }

    public function getModel(string $entity): string
    {
        return $this->entities[$entity]['model'] ?? throw new NotFoundHttpException('Model "' . $entity . '" not found');
    }

    public function getRequestEntities(string $entity)
    {
        return $this->entities[$entity] ?? throw new NotFoundHttpException('Request entities "' . $entity . '" not found');
    }
}
