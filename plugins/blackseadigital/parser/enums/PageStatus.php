<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Enums;

enum PageStatus: string
{
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';
    case PROCESSED = 'processed';
    case DELETED_MANUALLY = 'deleted_manually';
}
