<?php


namespace AdminPanel\Support\Auth;



use AdminPanel\Support\Contract\UserProviderFacade;

class ColumnAuth
{

    public function checkIsAdmin($userId)
    {
        $user = UserProviderFacade::findUser($userId);

        return $user->{config('admin_panel.column')};
    }

}
