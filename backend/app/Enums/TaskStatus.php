<?php

namespace App\Enums;

enum TaskStatus: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::NEW => 'новая',
            self::IN_PROGRESS => 'в работе',
            self::COMPLETED => 'выполнено'
        };
    }
}
