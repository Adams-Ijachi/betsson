<?php

namespace App\Enums;

enum NotificationTypeEnum:string
{
    case SUCCESS = 'success';
    case WARNING = 'warning';
    case ERROR = 'error';
}
