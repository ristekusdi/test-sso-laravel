<?php

namespace App\Services\Auth;

use RistekUSDI\SSO\Auth\Guard\WebGuard as SSOWebGuard;
use RistekUSDI\SSO\Facades\SSOWeb;
use App\Facades\AppSession;

class WebGuard extends SSOWebGuard
{
    public function authenticate()
    {
        // Get Credentials
        $credentials = SSOWeb::retrieveToken();
        if (empty($credentials)) {
            return false;
        }

        $user = SSOWeb::getUserProfile($credentials);
        if (empty($user)) {
            SSOWeb::forgetToken();
            return false;
        }
        
        /**
         * NOTE
         * Sometimes, you maybe want to bind user data with session.
         * Here's the way.
         */
        $user = AppSession::bindWithExtraData($user);
        
        $user = $this->provider->retrieveByCredentials($user);
        $this->setUser($user);
        
        return true;
    }

    public function permissions()
    {
        if (! $this->check()) {
            return false;
        }

        // role_permission attribute get from $custom_fillable.
        return $this->user()->role_permissions;
    }

    public function changeRoleActive($role_active)
    {
        AppSession::changeRoleActive($role_active);
        return true;
    }
}