<?php


namespace EasyPanel\Http\Livewire\Translation;


use Livewire\Component;
use EasyPanel\Services\LangManager;

class Manage extends Component
{
    public $selectedLang;
    public $texts;

    public function mount()
    {
        $this->selectedLang = (config('easy_panel.lang') ?? 'en').'_panel';
        $this->texts = LangManager::getTexts($this->selectedLang);
    }

    public function updatedSelectedLang($value)
    {
        $this->texts = LangManager::getTexts($value);
    }

    public function render()
    {
        return view('admin::livewire.translation.manage')
            ->layout('admin::layouts.app');
    }

    public function update()
    {
        LangManager::updateLanguage($this->selectedLang, $this->texts);

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Translation') ])]);
    }
}
