/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	config.language = 'zh-cn';
	//config.uiColor = '#AADC6E';
	//config.uiColor = '#27221F';
	config.toolbar = "Full";
	//config.dialog_backgroundCoverColor='rgb(39,34,31)'; //ø……Ë÷√≤Œøº
	//config.uiColor = '#FFF';
	config.toolbar_Full =
    [
	    ['Source','-','NewPage','Preview'],
	    ['Undo', 'Redo', '-', 'SelectAll'],
	    ['FontSize'],
	    ['TextColor'],
	    ['Link','Unlink'],
	    ['Maximize', 'About']
	    	    
    ]; 
	
};
