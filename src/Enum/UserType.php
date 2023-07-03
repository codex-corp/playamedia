<?php

namespace App\Enum;

use App\DBAL\EnumType;

class UserType extends EnumType
{
    public const MEMBER = 'member';
    public const USER = 'user';
    public const ADMIN = 'admin';

    protected static string $name = 'user_type';
}
