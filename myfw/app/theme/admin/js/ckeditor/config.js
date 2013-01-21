CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.extraPlugins = 'autogrow,syntaxhighlight';

    // CK Finder
    config.filebrowserBrowseUrl = ADMIN_URL + '/ckfinder/popup';
    config.filebrowserImageBrowseUrl = ADMIN_URL + '/ckfinder/popup?type=Images';
    config.filebrowserFlashBrowseUrl = ADMIN_URL + '/ckfinder/popup?type=Flash';
};
