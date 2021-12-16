//if ( document.location.protocol == 'file:' )
//	alert( 'Warning: This samples does not work when loaded from local filesystem' +
//	'due to security restrictions implemented in Flash.' +
//	'\n\nPlease load the sample from a web server instead.' );

window.editorFlashConfig = {
		language: 'en',
		/*
		 * Ensure that htmlwriter plugin, which is required for this sample, is loaded.
		 */
		extraPlugins: 'htmlwriter',
		height: 115,
		width: '100%',
		toolbar: [
			[ 'Font', 'FontSize']
			, [ //'Source', '-',
				'TextColor', 'Bold', 'Italic', 'Underline', // 'BulletedList', '-', 'Link', 'Unlink'
//			]
//			, [
				'JustifyLeft', 'JustifyCenter', 'JustifyRight' //, 'JustifyBlock'
			]
			//, '/', [ '-', 'About' ]
		],
		/*
		 * Style sheet for the contents
		 */
		contentsCss: 'body {color:#000; background-color#FFF; font-family: Arial; font-size:80%;} p, ol, ul {margin-top: 0px; margin-bottom: 0px;}',
		/*
		 * Quirks doctype
		 */
		docType: '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">',
		/*
		 * Core styles.
		 */
		coreStyles_bold: { element: 'b' },
		coreStyles_italic: { element: 'i' },
		coreStyles_underline: { element: 'u' },
		/*
		 * Font face.
		 */
		// Define the way font elements will be applied to the document. The "font"
		// element will be used.
		font_style: {
			element: 'font',
			attributes: { 'face': '#(family)' }
		},
		/*
		 * Font sizes.
		 */
		// The CSS part of the font sizes isn't used by Flash, it is there to get the
		// font rendered correctly in CKEditor.
		fontSize_sizes: '8px/8;9px/9;10px/10;11px/11;12px/12;14px/14;16px/16;18px/18;20px/20;22px/22;24px/24;26px/26;28px/28;36px/36;48px/48;72px/72',
		fontSize_style: {
			element: 'font',
			attributes: { 'size': '#(size)' },
			styles: { 'font-size': '#(size)px' }
		} ,
		/*
		 * Font colors.
		 */
		colorButton_enableMore: true,
		colorButton_foreStyle: {
			element: 'font',
			attributes: { 'color': '#(color)' }
		},
		colorButton_backStyle: {
			element: 'font',
			styles: { 'background-color': '#(color)' }
		},
		on: { 'instanceReady': configureFlashOutput }
	};
//var editor = CKEDITOR.replace( 'editor1', editorFlashConfig);

/*
 * Adjust the behavior of the dataProcessor to match the
 * requirements of Flash
 */
function configureFlashOutput ( ev ) {
	var editor = ev.editor,
		dataProcessor = editor.dataProcessor,
		htmlFilter = dataProcessor && dataProcessor.htmlFilter;
	// Out self closing tags the HTML4 way, like <br>.
	dataProcessor.writer.selfClosingEnd = '>';
	// Make output formatting match Flash expectations
	var dtd = CKEDITOR.dtd;
	for ( var e in CKEDITOR.tools.extend( {}, dtd.$nonBodyContent, dtd.$block, dtd.$listItem, dtd.$tableContent ) ) {
		dataProcessor.writer.setRules( e, {
			indent: false,
			breakBeforeOpen: false,
			breakAfterOpen: false,
			breakBeforeClose: false,
			breakAfterClose: false
		});
	}
	dataProcessor.writer.setRules( 'br', {
		indent: false,
		breakBeforeOpen: false,
		breakAfterOpen: false,
		breakBeforeClose: false,
		breakAfterClose: false
	});
	// Output properties as attributes, not styles.
	htmlFilter.addRules( {
		elements: {
			$: function( element ) {
				var style, match, width, height, align;
				// Output dimensions of images as width and height
				if ( element.name == 'img' ) {
					if ( style = element.attributes.style ) {
						// Get the width from the style.
						match = ( /(?:^|\s)width\s*:\s*(\d+)px/i ).exec( style );
						width = match && match[1];
						// Get the height from the style.
						match = ( /(?:^|\s)height\s*:\s*(\d+)px/i ).exec( style );
						height = match && match[1];
						if ( width ) {
							//element.attributes.style = element.attributes.style.replace( /(?:^|\s)width\s*:\s*(\d+)px;?/i , '' );
							element.attributes.width = width;
						}
						if ( height ) {
							//element.attributes.style = element.attributes.style.replace( /(?:^|\s)height\s*:\s*(\d+)px;?/i , '' );
							element.attributes.height = height;
						}
					}
				}
				// Output alignment of paragraphs using align
				if ( element.name == 'p' ) {
					if ( style = element.attributes.style ) {
						// Get the align from the style.
						match = ( /(?:^|\s)text-align\s*:\s*(\w*);?/i ).exec( style );
						align = match && match[1];
						if ( align = (align || 'left') ) {
							//element.attributes.style = element.attributes.style.replace( /(?:^|\s)text-align\s*:\s*(\w*);?/i , '' );
							element.attributes.align = align;
						}
					}
					else element.attributes.align = 'left';
				}
				if ( element.attributes.style === '' )
					delete element.attributes.style;
				return element;
			}
		}
	});
};

/**
function sendToFlash() {
	var html = CKEDITOR.instances.editor1.getData() ;
	// Quick fix for link color.
	html = html.replace( /<a /g, '<font color="#0000FF"><u><a ' )
	html = html.replace( /<\/a>/g, '</a></u></font>' )
	var flash = document.getElementById( 'ckFlashContainer' ) ;
	flash.setData( html ) ;
}
CKEDITOR.domReady( function() {
	if ( !swfobject.hasFlashPlayerVersion( '8' ) ) {
		CKEDITOR.dom.element.createFromHtml( '<span class="alert">' +
		'At least Adobe Flash Player 8 is required to run this sample. ' +
		'You can download it from <a href="http://get.adobe.com/flashplayer">Adobe\'s website</a>.' +
		'</span>' ).insertBefore( editor.element );
	}
	swfobject.embedSWF(
		'assets/outputforflash/outputforflash.swf',
		'ckFlashContainer',
		'550',
		'400',
		'8',
		{ wmode: 'transparent' }
	);
});
 */
