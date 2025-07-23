<?php

namespace App\User\Enum;

enum UserRole: string
{
    case USER = 'ROLE_USER';
    case SUPER_ADMIN = 'ROLE_ADMIN';
    case CATEGORY_ADMIN = 'ROLE_CATEGORY_ADMIN';
    case PRODUCT_ADMIN = 'ROLE_PRODUCT_ADMIN';
    case USER_ADMIN = 'ROLE_USER_ADMIN';
}