<?php

namespace EasyPanelTest\Unit;

use App\Models\Article;
use EasyPanelTest\Dependencies\User;
use Illuminate\Support\Str;

class StubParserTest extends \EasyPanelTest\TestCase
{

    /** @test * */
    public function make_tab_works(){
        $expected = "\n    ";
        $this->assertEquals($expected, $this->parser->makeTab(1));

        $expected = "    ";
        $this->assertEquals($expected, $this->parser->makeTab(1, false));

        $expected = "        ";
        $this->assertEquals($expected, $this->parser->makeTab(2, false));
    }

    /** @test * */
    public function get_model_name_gives_true_name(){
        $this->assertEquals("Article", $this->parser->getModelName(Article::class));
        $this->assertEquals("User", $this->parser->getModelName(User::class));
    }

    /** @test * */
    public function properties_will_be_parsed(){
        $this->parser->setInputs(['title' => 'text', 'content' => 'textarea']);
        $expected1 = 'public $title;';
        $expected2 = '    public $content;';
        $properties = $this->parser->parseProperties();
        $this->assertStringContainsString($expected1, $properties);
        $this->assertStringContainsString($expected2, $properties);
    }

    /** @test * */
    public function properties_value_will_filled_in_actions(){
        $this->parser->setInputs(['title' => 'text', 'content' => 'textarea']);
        $expected1 = '\'title\' => $this->title,';
        $expected2 = '\'content\' => $this->content,';
        $this->assertStringContainsString($expected1, $this->parser->parseActionInComponent());
        $this->assertStringContainsString($expected2, $this->parser->parseActionInComponent());

        $this->parser->setAuthType(true);
        $expected1 = '\'user_id\' => auth()->id(),';
        $this->assertStringContainsString($expected2, $this->parser->parseActionInComponent());

        $this->parser->setAuthType(false);
        $expected1 = '\'user_id\' => auth()->id(),';
        $this->assertStringNotContainsString($expected1, $this->parser->parseActionInComponent());
    }

    /** @test * */
    public function validation_will_be_parsed(){
        $this->parser->setValidationRules([
            'title' => 'required',
            'content' => 'min:10'
        ]);
        $expected1 = "'title' => 'required'";
        $expected2 = "        'content' => 'min:10'";
        $parsedString = $this->parser->parseValidationRules();
        $this->assertStringContainsString($expected1, $parsedString);
        $this->assertStringContainsString($expected2, $parsedString);
    }

    /** @test * */
    public function data_string_will_be_replaced(){
        $this->parser->setFields(['title']);
        $expected = '<td> {{ $article->title }} </td>';
        $this->assertStringContainsString($expected, $this->parser->parseDataInBlade());

        $this->parser->setFields(['user.name']);
        $expected = '<td> {{ $article->user->name }} </td>';
        $this->assertStringContainsString($expected, $this->parser->parseDataInBlade());

        $this->parser->setFields(['image']);
        $expected = '<img class="rounded-circle img-fluid" width="50" height="50" src="{{ asset($article->image) }}" alt="image">';
        $this->assertStringContainsString($expected, $this->parser->parseDataInBlade());
    }

    /** @test * */
    public function titles_of_table_will_be_parsed(){
        $this->parser->setFields(['title']);
        $expected = "wire:click=\"sort('title')\"";
        $expected2 = "{{ __('Title') }}";
        $this->assertStringContainsString($expected, $this->parser->parseTitlesInBlade());
        $this->assertStringContainsString($expected2, $this->parser->parseTitlesInBlade());

        $this->parser->setFields(['user.name']);
        $notExpected = "wire:click=\"sort('title')\"";
        $expected = "{{ __('User Name') }}";
        $this->assertStringNotContainsString($notExpected, $this->parser->parseTitlesInBlade());
        $this->assertStringContainsString($expected, $this->parser->parseTitlesInBlade());
    }

    /** @test * */
    public function relational_field_names_will_be_parsed_successfully(){
        $field = 'user.name';
        $expected = 'User Name';
        $this->assertEquals($expected, $this->parser->parseFieldNameWithDots($field));

        $field = 'user.image.file';
        $expected = 'User Image File';
        $this->assertEquals($expected, $this->parser->parseFieldNameWithDots($field));
    }

    /** @test * */
    public function dots_will_be_replaced_with_arrow(){
        $field = 'user.name';
        $expected = 'user->name';
        $this->assertEquals($expected, $this->parser->parseDots($field));
    }

    /** @test * */
    public function properties_will_be_filled_for_actions(){
        $this->parser->setInputs([
            'title' => 'text',
            'body' => 'ckeditor',
        ]);

        $expected1 = '$this->title = $this->article->title;'."\n";
        $expected2 = '$this->body = $this->article->body;';
        $parsedString = $this->parser->parseSetPropertiesValue();
        $this->assertStringContainsString($expected1, $parsedString);
        $this->assertStringContainsString($expected2, $parsedString);
    }

    /** @test * */
    public function texts_will_be_set_to_translate(){
        $this->parser->setInputs([
            'title' => 'text',
            'body' => 'ckeditor',
            'image' => 'file',
        ]);
        $this->parser->parseInputsInBlade();
        $this->assertContains('Title', $this->parser->texts);
        $this->assertContains('Body', $this->parser->texts);
        $this->assertContains('Image', $this->parser->texts);

        $this->parser->setFields(['title', 'image', 'user.name']);
        $this->parser->parseTitlesInBlade();
        $this->assertContains('User Name', $this->parser->texts);
        $this->assertContains('Title', $this->parser->texts);
        $this->assertContains('Image', $this->parser->texts);

        $this->assertCount(4, $this->parser->texts);
    }

}
