<?php

namespace App\Services;

use App\Enums\TaskStatus;
use App\Http\Requests\Request;
use App\Traits\RequestModel;
use Illuminate\Http\Request as HttpRequest;

class CRUDBuilder
{
    use RequestModel;

    private array $data;

    private string $entity;

    private string $method;

    private Request $request_instance;

    private string $model_class;

    public function build(HttpRequest $request, string $method)
    {
        $this->entity = $request->entity;
        $this->method = $method;

        $this->data = $request->all();

        $request_class_name = $this->getRequest($this->entity);
        $this->request_instance = new $request_class_name();

        $this->model_class = $this->getModel($this->entity);

        return $this;
    }

    public function create()
    {
        $validated = $this->validate($this->data);
        $item = $this->model_class::create($validated);
        return $item;
    }

    public function get(?int $id = null)
    {
        return ($id) ? $this->model_class::findOrFail($id) : $this->model_class::all();
    }

    public function update(int $id)
    {
        $validated = $this->validate($this->data);
        $item = $this->model_class::findOrFail($id);
        $item->update($validated);
        return $item;
    }

    public function delete(int $id)
    {
        $item = $this->model_class::findOrFail($id);
        $item->delete();
        return $item;
    }

    private function validate(array $data)
    {
        $rules = $this->request_instance->getRules($this->method);
        return $this->request_instance->validate($data, $rules);
    }
}
