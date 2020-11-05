<?php

namespace AdminPanel\Support\User;

class UserProvider
{

    public function makeAdmin($id)
    {
        $user = $this->findUser($id);
        $user->update([
            config('admin_panel.column') => 1
        ]);
    }

    public function findUser($id)
    {
        return config('admin_panel.user_model')::query()->findOrFail($id);
    }

    public function deleteAdmin($id)
    {
        $user = $this->findUser($id);
        $user->update([
            config('admin_panel.column') => 0
        ]);
    }

}
