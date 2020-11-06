<?php


namespace EasyPanel\Support\User;


class TestModeUserProvider
{

    public function makeAdmin($id)
    {
        $this->findUser($id);
        // do nothing..
    }

    public function findUser($id)
    {
        return (object) [
            'id' => $id,
            'is_admin' => 0
        ];
    }

}
