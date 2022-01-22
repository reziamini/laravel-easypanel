<?php


namespace EasyPanelTest;


use EasyPanel\Http\Middleware\isAdmin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class MiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /** @test * */
    public function user_is_unauthorized(){
        \Illuminate\Support\Facades\Route::get('/admin')
            ->middleware(isAdmin::class);

        $this->actingAs($this->user);

        $this->get('/admin')
            ->assertRedirect('/');

        config()->set('easy_panel.redirect_unauthorized', '/redirect-page');

        $this->get('/admin')
            ->assertRedirect('/redirect-page');
    }

    /** @test * */
    public function user_is_valid(){
        $this->withoutExceptionHandling();

        \Illuminate\Support\Facades\Route::get('/admin', function (){})
            ->middleware(isAdmin::class);

        $this->user->panelAdmin()->create([
            'is_superuser' => true
        ]);

        $this->actingAs($this->user->refresh())
            ->get('/admin')
            ->assertOk();
    }

    /** @test * */
    public function language_will_be_set(){
        $this->user->panelAdmin()->create([
            'is_superuser' => true
        ]);

        $this->actingAs($this->user->refresh())->get('/admin');

        $this->assertEquals('en_panel', App::getLocale());
    }

    /** @test * */
    public function a_guest_user_will_be_redirected(){
        \Illuminate\Support\Facades\Route::get('/test')
            ->middleware(isAdmin::class);

        $this->get('/test')
            ->assertRedirect();

        config()->set('easy_panel.redirect_unauthorized', '/redirect-page');
        $this->get('/test')
            ->assertRedirect('/redirect-page');
    }

    /** @test * */
    public function a_custom_language_is_applied()
    {
        config()->set('easy_panel.lang', 'fa');

        $this->user->panelAdmin()->create([
            'is_superuser' => true
        ]);

        $this->actingAs($this->user->refresh())->get('/admin');

        $this->assertEquals('fa_panel', App::getLocale());
    }

    /** @test * */
    public function a_default_language_is_applied_when_its_null()
    {
        config()->set('easy_panel.lang', null);

        $this->user->panelAdmin()->create([
            'is_superuser' => true
        ]);

        $this->actingAs($this->user->refresh())->get('/admin');

        $this->assertEquals('en_panel', App::getLocale());
    }

    /** @test * */
    public function auth_guard_is_read_from_config(){
        config()->set('easy_panel.auth_guard', '::test_guard::');
        \Illuminate\Support\Facades\Route::get('/admin')->middleware(isAdmin::class);

        $this->user->panelAdmin()->create([
            'is_superuser' => true
        ]);

        $this->actingAs($this->user->refresh())->get('/admin');

        $this->assertEquals('::test_guard::', Auth::getDefaultDriver());
    }
}
