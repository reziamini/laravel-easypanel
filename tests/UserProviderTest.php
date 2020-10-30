<?php


namespace AdminPanel\tests;


use AdminPanel\Support\Contract\UserProviderFacade;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UserProviderTest extends TestCase
{

    /** @test * */
    public function does_make_user_work(){
        $user = User::factory(1)->create();

        Artisan::call('make:admin', ['user' => $user[0]->id]);

        $user = UserProviderFacade::findUser($user[0]->id);

        $this->assertTrue($user->is_superuser == 1);
    }

    /** @test * */
    public function show_error_when_user_does_not_exist(){
        $this->assertTrue(Artisan::call('make:admin', ['user' => 0]) == 0);
    }

}
