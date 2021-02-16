<?php

namespace EasyPanel\Parsers\HTMLInputs;

class Ckeditor
{

    public function handle($name)
    {
        return "<div wire:ignore>
                    <textarea class='form-control ckeditor' id='editor$name' wire:model='$name'></textarea>
                </div>
                <script>
                    ClassicEditor.create(document.querySelector('#editor$name'), {
                    @if(config('easy_panel.rtl_mode'))
                        language: 'fa'
                    @endif
                    }).then(editor => {
                        editor.setData('{!! $".$name." !!}');
                        editor.model.document.on('change:data', () => {
                            @this.$name = editor.getData()
                        });
                    });
                </script>";
    }
}
