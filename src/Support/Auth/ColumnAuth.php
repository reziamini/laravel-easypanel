<?php

namespace EasyPanel\Support\Auth;

use EasyPanel\Support\Contract\UserProviderFacade;

class ColumnAuth
{

    public function checkIsAdmin($userId)
    {
        $user = UserProviderFacade::findUser($userId);

        return $user->{config('easy_panel.column')};
    }

}
