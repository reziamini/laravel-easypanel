<?php

namespace EasyPanel\Support\User;

class UserProvider
{

    public function makeAdmin($id)
    {
        $user = $this->findUser($id);
        $user->update([
            config('easy_panel.column') => true
        ]);
    }

    public function findUser($id)
    {
        return config('easy_panel.user_model')::query()->findOrFail($id);
    }

    public function deleteAdmin($id)
    {
        $user = $this->findUser($id);
        $user->update([
            config('easy_panel.column') => false
        ]);
    }

}
