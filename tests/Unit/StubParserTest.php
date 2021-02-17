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

    /** @test * */
    public function model_namespace_will_be_render_successfully(){
        config()->set('easy_panel.crud.article.model', Article::class);

        $this->assertEquals(Article::class, $this->parser->replaceModel('{{ modelNamespace }}'));
        $this->assertEquals("App\\Models\\Article", $this->parser->replaceModel('{{ modelNamespace }}'));
    }

    /** @test * */
    public function upload_code_will_be_generated(){
        // With customized store path
        config()->set('easy_panel.crud.article.fields', ['image' => 'file']);
        config()->set('easy_panel.crud.article.store', ['image' => 'images/articles']);

        $renderedCode = $this->parser->replaceModel('{{ uploadFile }}');

        $excepted = 'if($this->getPropertyValue(\'image\') and is_object($this->image)) {';
        $this->assertTrue(Str::contains($renderedCode, $excepted));

        $excepted = '$this->image = $this->getPropertyValue(\'image\')->store(\'images/articles\')';
        $this->assertTrue(Str::contains($renderedCode, $excepted));

        // With default store path
        config()->set('easy_panel.crud.article.fields', ['image' => 'file']);
        config()->set('easy_panel.crud.article.store', []);

        $renderedCode = $this->parser->replaceModel('{{ uploadFile }}');

        $excepted = '$this->image = $this->getPropertyValue(\'image\')->store(\'image\')';
        $this->assertTrue(Str::contains($renderedCode, $excepted));
    }

    /** @test * */
    public function properties_will_be_parsed(){
        config()->set('easy_panel.crud.article.fields', [
            'image' => 'file',
            'title' => 'text',
            'content' => 'ckeditor'
        ]);

        $renderedCode = $this->parser->replaceModel('{{ properties }}');

        $excepted = 'public $image';
        $this->assertTrue(Str::contains($renderedCode, $excepted));

        $excepted = 'public $title';
        $this->assertTrue(Str::contains($renderedCode, $excepted));

        $excepted = 'public $content';
        $this->assertTrue(Str::contains($renderedCode, $excepted));

        config()->set('easy_panel.crud.article.fields', []);
        $renderedCode = $this->parser->replaceModel('{{ properties }}');
        $this->assertEmpty($renderedCode);
    }

    /** @test * */
    public function rules_will_be_rendered(){
        config()->set('easy_panel.crud.article.validation', [
            'title' => 'required',
            'content' => 'required|min:30',
        ]);

        $renderedCode = $this->parser->replaceModel('{{ rules }}');

        $excepted = "'title' => 'required'";
        $this->assertTrue(Str::contains($renderedCode, $excepted));

        $excepted = "'content' => 'required|min:30'";
        $this->assertTrue(Str::contains($renderedCode, $excepted));

        config()->set('easy_panel.crud.article.validation', []);
        $renderedCode = $this->parser->replaceModel('{{ rules }}');
        $this->assertEmpty($renderedCode);
    }

    /** @test * */
    public function fields_will_be_filled()
    {
        config()->set('easy_panel.crud.article.fields', ['image' => 'file', 'title' => 'text']);

        $renderedCode = $this->parser->replaceModel('{{ fields }}');

        $excepted = '\'image\' => $this->image';
        $this->assertTrue(Str::contains($renderedCode, $excepted));

        $excepted = '\'title\' => $this->title';
        $this->assertTrue(Str::contains($renderedCode, $excepted));
    }

    /** @test * */
    public function properties_will_be_set(){
        config()->set('easy_panel.crud.article.fields', ['image' => 'file', 'title' => 'text']);

        $renderedCode = $this->parser->replaceModel('{{ setProperties }}');

        $excepted = '$this->image = $this->article->image';
        $this->assertTrue(Str::contains($renderedCode, $excepted));

        $excepted = '$this->title = $this->article->title';
        $this->assertTrue(Str::contains($renderedCode, $excepted));
    }
}
