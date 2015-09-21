/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	config.height = 400; //高度
	config.filebrowserBrowseUrl =      './include/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = './include/ckfinder/ckfinder.html?Type=Images';
	config.filebrowserFlashBrowseUrl = './include/ckfinder/ckfinder.html?Type=Flash';
	config.filebrowserUploadUrl = 	   './include/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = './include/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl = './include/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};
