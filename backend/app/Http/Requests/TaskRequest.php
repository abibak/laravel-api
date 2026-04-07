<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use Illuminate\Validation\Rules\Enum;

class TaskRequest extends Request
{
    protected array $rules = [];

    public function __construct()
    {
        $this->defineRules();
    }

    protected function defineRules(): void
    {
        $base_rules = [
            'title' => 'bail|required|string|max:256',
            'description' => 'bail|required|string|max:512',
            'status' => [
                'required',
                new Enum(TaskStatus::class)
            ]
        ];

        $this->rules =  [
            'create' => $base_rules,
            'update' => $base_rules
        ];
    }

    public function getRules(string $method): array
    {
        return $this->rules[$method];
    }
}
