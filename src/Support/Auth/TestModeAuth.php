<?php


namespace EasyPanel\Support\Auth;


class TestModeAuth
{

    public function checkIsAdmin($userId)
    {
        return true;
    }

}
