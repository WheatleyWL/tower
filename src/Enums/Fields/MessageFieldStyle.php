<?php

namespace zedsh\tower\Enums\Fields;

enum MessageFieldStyle : string
{
    case SUCCESS = 'alert-success';
    case WARNING = 'alert-warning';
    case DANGER = 'alert-danger';
    case INFO = 'alert-info';

    case PRIMARY = 'alert-primary';
    case SECONDARY = 'alert-secondary';
}
