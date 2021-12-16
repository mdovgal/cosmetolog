CKEDITOR.plugins.add( 'lettersnip', {
    icons: 'lettersnip',
    init: function( editor ) {
        /*
        editor.addCommand( 'insertLetterSnip', {
            exec: function( editor ) {
                console.log('exec');
                    editor.insertHtml( '{FIRSTNAME}' );
            }
        });
        editor.ui.addButton( 'Firstname', {
                    label: 'Insert Firstname',
                    command: 'insertLetterSnip',
                    toolbar: 'insert'
        });
        editor.ui.addCombobox( 'lSnip', {
        });
        */

        editor.ui.addRichCombo('lsnip',
        {
            label: 'Placeholders',
            title: 'Placeholders',
            voiceLabel: 'Placeholders',
            className: 'cke_format',
            multiSelect:false,
            panel:
                {
                css: [ editor.config.contentsCss, CKEDITOR.skin.getPath('editor') ],
                voiceLabel: editor.lang.panelVoiceLabel
                },

            init: function()
            {
                this.startGroup( "Letter Snip" );
                for (var i in letterSnippetList)
                {
                    this.add(letterSnippetList[i][0], letterSnippetList[i][1], letterSnippetList[i][2]);
                }
            },

            onClick: function( value )
            {
                editor.focus();
                editor.fire( 'saveSnapshot' );
                editor.insertHtml(value);
                editor.fire( 'saveSnapshot' );
            }
        });
    }
});
