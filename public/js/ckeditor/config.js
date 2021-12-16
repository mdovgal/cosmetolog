/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.removePlugins = 'elementspath';
    config.resize_enabled = false;
    config.toolbar = 'Full';
    //width: 600,
    //height: 300,
    //resize_dir: 'both',
    //resize_minWidth: 200,
    //resize_minHeight: 300,
    //resize_maxWidth: 800,

    config.toolbar_Full =
        [
            //{ name: 'basicstyles', items : [ 'Font','FontSize','TextColor','Bold','Italic','Underline','JustifyLeft','JustifyCenter','JustifyRight' ] }
            { name: 'document', items: [ 'Preview', 'Source' ] },
            { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
            { name: 'basicstyles', items: [ 'Bold', 'Italic','Underline' ] },
            { name: 'font', items: ['Font', 'FontSize', 'TextColor']},
            { name: 'align', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight']},
            { name: 'insert', items: ['Link', 'Image', '-', 'Blockquote']}
        ];
};