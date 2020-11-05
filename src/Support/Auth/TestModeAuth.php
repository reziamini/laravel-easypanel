<?php


namespace AdminPanel\Support\Auth;


class TestModeAuth
{

    public function checkIsAdmin($userId)
    {
        return true;
    }

}
