<?php

namespace App\Http\Controllers\API;

use App\Services\CRUDBuilder;
use App\Traits\APIResponse;
use App\Traits\RequestModel;
use Illuminate\Http\Request;

class MainController
{
    use RequestModel, APIResponse;

    private CRUDBuilder $builder;

    public function __construct()
    {
        $this->builder = new CRUDBuilder();
    }

    public function create(Request $request)
    {
        $created = $this->builder->build($request, 'create')->create();
        return $this->sendSuccessResponse($created, 'Created', 201);
    }

    public function get(Request $request)
    {
        $data = $this->builder->build($request, 'get')->get($request->id);
        return $this->sendSuccessResponse($data, 'Received', 200);
    }

    public function update(Request $request)
    {
        $updated = $this->builder->build($request, 'update')->update($request->id);
        return $this->sendSuccessResponse($updated, 'Updated', 200);
    }

    public function delete(Request $request)
    {
        $deleted = $this->builder->build($request, 'delete')->delete($request->id);
        return $this->sendSuccessResponse($deleted, 'Deleted', 200);
    }
}
