/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.extraPlugins = 'autogrow,syntaxhighlight';

    // CK Finder
    config.filebrowserBrowseUrl = 'http://web.local/github/development/myfw/app/theme/admin/js/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = 'http://web.local/github/development/myfw/app/theme/admin/js/ckfinder/ckfinder.html?type=Images';
    config.filebrowserFlashBrowseUrl = 'http://web.local/github/development/myfw/app/theme/admin/js/ckfinder/ckfinder.html?type=Flash';
};
