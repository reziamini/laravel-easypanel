<?php


namespace AdminPanel\Support\User;


use App\Models\User;

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
        return User::query()->findOrFail($id);
    }

    public function deleteAdmin($id)
    {
        $user = $this->findUser($id);
        $user->update([
            config('admin_panel.column') => 0
        ]);
    }

}
