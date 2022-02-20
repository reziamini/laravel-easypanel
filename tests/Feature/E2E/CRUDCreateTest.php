<?php

namespace EasyPanelTest\Feature\E2E;

use EasyPanelTest\TestCase;
use Livewire\Livewire;
use EasyPanel\Http\Livewire\CRUD\Create;

class CRUDCreateTest extends TestCase
{

    /** @test * */
    public function it_opens_the_drop_down(){
        Livewire::test(Create::class)
            ->call('setModel')
            ->assertSet('dropdown', true);
    }

    /** @test * */
    public function it_closes_the_drop_down(){
        Livewire::test(Create::class)
            ->call('closeModal')
            ->assertSet('dropdown', false);
    }

    /** @test * */
    public function it_shows_the_drop_down_after_updating_model(){
        Livewire::test(Create::class)
            ->set('model', 'A')
            ->assertSet('dropdown', true);
    }

}
