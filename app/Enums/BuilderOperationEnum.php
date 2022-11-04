<?php

namespace App\Enums;

enum BuilderOperationEnum: string
{
    case where = 'where';
    case whereNot = 'whereNot';
    case orWhere = 'orWhere';
    case orWhereNot = 'orWhereNot';
}
