<?php

namespace EasyPanelTest\Unit;

use App\Models\Article;
use EasyPanelTest\Dependencies\User;
use Illuminate\Support\Str;

class StubParserTest extends \EasyPanelTest\TestCase
{
    /** @test * */
    public function get_config_works(){
        config()->set('easy_panel.crud.article.search', ['title']);

        $this->assertEquals($this->parser->getConfig('search'), ['title']);
        $this->assertEquals($this->parser->getConfig('search', 'article'), ['title']);
    }

    /** @test * */
    public function make_tab_works(){
        $excepted = "\n    ";
        $this->assertEquals($excepted, $this->parser->makeTab(1));

        $excepted = "    ";
        $this->assertEquals($excepted, $this->parser->makeTab(1, false));

        $excepted = "        ";
        $this->assertEquals($excepted, $this->parser->makeTab(2, false));
    }

    /** @test * */
    public function get_model_name_gives_true_name(){
        $this->assertEquals("Article", $this->parser->getModelName(Article::class));
        $this->assertEquals("User", $this->parser->getModelName(User::class));
    }

    /** @test * */
    public function get_model_in_parse_blade(){
        $this->assertEquals('article', $this->parser->parseBlade('{{ model }}'));
    }

    /** @test * */
    public function get_model_name_in_parse_blade(){
        $this->assertEquals('Article', $this->parser->parseBlade('{{ modelName }}'));
        $this->assertContains('Article', $this->parser->texts);
        $this->assertContains('Articles', $this->parser->texts);
    }

    /** @test * */
    public function data_string_will_be_replaced(){
        config()->set('easy_panel.crud.article.show', ['title']);
        $excepted = '<td> {{ $article->title }} </td>';
        $this->assertTrue(Str::contains($this->parser->parseBlade('{{ data }}'), $excepted));

        config()->set('easy_panel.crud.article.show', [['user' => 'name']]);
        $excepted = '<td> {{ $article->user->name }} </td>';
        $this->assertTrue(Str::contains($this->parser->parseBlade('{{ data }}'), $excepted));

        config()->set('easy_panel.crud.article.show', ['image']);
        $excepted = '<img class="rounded-circle img-fluid" width="50" height="50" src="{{ asset($article->image) }}" alt="image">';
        $this->assertTrue(Str::contains($this->parser->parseBlade('{{ data }}'), $excepted));
    }

    /** @test * */
    public function titles_string_will_be_replaced(){
        config()->set('easy_panel.crud.article.show', ['title']);
        $excepted = "{{ __('Title') }}";
        $excepted2 = 'wire:click="sort(\'title\')"';
        $this->assertTrue(Str::contains($this->parser->parseBlade('{{ titles }}'), $excepted));
        $this->assertTrue(Str::contains($this->parser->parseBlade('{{ titles }}'), $excepted2));
        $this->assertContains('Title', $this->parser->texts);

        config()->set('easy_panel.crud.article.show', [['user' => 'name']]);
        $excepted = "{{ __('User Name') }}";
        $excepted2 = 'wire:click="sort(\'user name\')"';
        $this->assertTrue(Str::contains($this->parser->parseBlade('{{ titles }}'), $excepted));
        $this->assertFalse(Str::contains($this->parser->parseBlade('{{ titles }}'), $excepted2));
        $this->assertContains('User Name', $this->parser->texts);
    }
}
