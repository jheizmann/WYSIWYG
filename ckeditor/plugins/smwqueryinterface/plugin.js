CKEDITOR.plugins.add('smw_qi', {

    requires : [ 'mediawiki', 'dialog' ],
    
	init : function( editor )
	{
		editor.addCss(
			'img.FCK__SMWquery' +
			'{' +
				'background-image: url(' + CKEDITOR.getUrl( this.path + 'images/tb_icon_ask.gif' ) + ');' +
				'background-position: center center;' +
				'background-repeat: no-repeat;' +
				'border: 1px solid #a9a9a9;' +
				'width: 18px !important;' +
				'height: 18px !important;' +
			'}\n'
        );
        
		editor.addCommand( 'SMWqi', new CKEDITOR.dialogCommand( 'SMWqi' ) );
        CKEDITOR.dialog.add( 'SMWqi', this.path + 'dialogs/smwQiDlg.js');

        if (editor.addMenuItem) {
            // A group menu is required
            // order, as second parameter, is not required
            editor.addMenuGroup('mediawiki');
            // Create a menu item
            editor.addMenuItem('SMWqi', {
                label: 'Query Interface',
                command: 'SMWqi',
                group: 'mediawiki'
            });
        }

        if ( editor.ui.addButton ) {
            editor.ui.addButton( 'SMWqi',
                {
                    label : 'Query Interface',
                    command : 'SMWqi',
                    icon: this.path + 'images/tb_icon_ask.gif'
                });
        }
        // context menu
        if (editor.contextMenu) {
            editor.contextMenu.addListener(function(element, selection) {
                var name = element.getName();
                // fake image for some <span> with special tag
                if ( name == 'img' && element.getAttribute( 'class' ) == 'FCK__SMWquery' )
                    return { SMWqi: CKEDITOR.TRISTATE_ON };
            });
        }
		

	}
});