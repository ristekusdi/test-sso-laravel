<?php

namespace App;

use RistekUSDI\SSO\Models\User as SSOUser;

class User extends SSOUser
{
    public $custom_fillable = [
        'unud_identifier_id',
        'unud_user_type_id',
        'role_active',
        'role_permissions',
        'arr_menu',
    ];
}
