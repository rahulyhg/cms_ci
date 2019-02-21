/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) { 
	var root = location.protocol + '//' + location.host+ '/cms_ci';
	var path = root+'/assets/tools';
	config.filebrowserBrowseUrl = path+'/kcfinder/browse.php?type=files';
	config.filebrowserImageBrowseUrl = path+'/kcfinder/browse.php?type=images&dir=images/content';
	config.filebrowserFlashBrowseUrl = path+'/kcfinder/browse.php?type=flash';
	config.filebrowserUploadUrl = path+'/kcfinder/upload.php?type=files';
	config.filebrowserImageUploadUrl = path+'/kcfinder/upload.php?type=images';
	config.filebrowserFlashUploadUrl = path+'/kcfinder/upload.php?type=flash';
	
	config.allowedContent = true;
	config.coreStyles_bold = { element: 'b', overrides: 'strong' };
	
	config.autoGrow_onStartup = true;
	config.extraPlugins = 'autogrow,youtube';
	/*config.extraPlugins = 'autogrow,fixed';*/
	config.removePlugins = 'resize';
	
	config.toolbar = [
		{ name: 'document', items : [ 'Source'] },
		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
		{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','Scayt' ] },
		{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'
				 ,'Iframe', 'Youtube' ] },
				'/',
		{ name: 'styles', items : [ 'Styles','Format', 'FontSize' ] },
		{ name: 'colors',      items : [ 'TextColor','BGColor' ] },
		{ name: 'basicstyles', items : [ 'Bold','Italic','Strike','-','RemoveFormat' ] },
		{ name: 'paragraph', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', '-', 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote' ] },
		{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
		{ name: 'tools', items : [ 'Maximize', 'ShowBlocks' ,'-','About' ] }
	];
};