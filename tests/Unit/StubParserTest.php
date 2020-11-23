<?php


class StubParserTest extends \EasyPanelTest\TestCase
{

    /**
     * @var \EasyPanelTest\Dependencies\StubTester
     */
    private $parser;

    public function __construct()
    {
        parent::__construct();
        $this->parser = new \EasyPanelTest\Dependencies\StubTester();
    }

    /** @test * */
    public function get_model_name_in_parser(){
        $model = $this->parser->getModelName(\EasyPanelTest\Dependencies\User::class);
        $this->assertEquals($model, 'User');
    }

    /** @test * */
    public function test_tab_creator(){
        $this->assertEquals("\n    ", $this->parser->makeTab(1));
        $this->assertEquals("\n    ", $this->parser->makeTab(1, true));
        $this->assertEquals("    ", $this->parser->makeTab(1, false));
        $this->assertEquals("        ", $this->parser->makeTab(2, false));
        $this->assertEquals("\n        ", $this->parser->makeTab(2));
    }

    /** @test * */
    public function parse_properties(){
        $properties = $this->parser->parseProperties(['title' => '']);
        $this->assertEquals('public $title;'.$this->parser->makeTab(1), $properties);
        $properties = $this->parser->parseProperties(['title' => '', 'content' => '']);
        $this->assertEquals('public $title;'.$this->parser->makeTab(1).'public $content;'.$this->parser->makeTab(1), $properties);
    }

    /** @test * */
    public function get_action_config(){
        config()->set('easy_panel.crud.article.search', 'title');
        $this->assertEquals($this->parser->getConfig('search', 'article'), 'title');
        $this->assertEquals($this->parser->getConfig('search', 'user'), []);
    }

}
