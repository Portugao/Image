'use strict';

var currentMUImageEditor = null;
var currentMUImageInput = null;

/**
 * Returns the attributes used for the popup window.
 * 
 * @return {String}
 */
/*
 * function getPopupAttributes() { var pWidth, pHeight;
 * 
 * pWidth = screen.width * 0.75; pHeight = screen.height * 0.66; return 'width=' +
 * pWidth + ',height=' + pHeight + ',scrollbars,resizable'; }
 * 
 * /** Open a popup window with the finder triggered by a Xinha button.
 */
/*
 * function MUImageFinderXinha(editor, muimageURL) { var popupAttributes; //
 * Save editor for access in selector window currentMUImageEditor = editor;
 * 
 * popupAttributes = getPopupAttributes(); window.open(muimageURL, 'neu',
 * popupAttributes); }
 * 
 * /** Open a dialog box with the finder triggered by a Xinha button.
 */
function MUImageFinderXinha(editor, muimageURL) {
	var MU = jQuery.noConflict();
	var albumdialog = MU('<div id="albumwindow"></div>');
	var imagedialog = MU('<div id="imagewindow"></div>');
	
	function LoadAlbums(editor, muimageURL) {
        MU.ajax({
        	url: muimageURL,
        	success: function(ergebnis) {
            if (ergebnis) {
                albumdialog.html(ergebnis);   
            }
            },
            cache: false
        });
	}
	LoadAlbums(editor, muimageURL);

	MU(albumdialog).dialog({
		title: Zikula.__('Choose an image of an MUImage album', 'module_muimage'),
		modal: true, 
	    width: 600,	
	    height: 400,
	    buttons: [
	        {
	        	text: Zikula.__('Load albums', 'module_muimage'),
	        	click: function() {
	        	    LoadAlbums(editor, muimageURL);	      	    
	        	}, 
	        },      
	        { 
	    	text: Zikula.__('Load images of the selected album', 'module_muimage'),
	    	click: function(e) {

	    	var url2 = Zikula.Config.baseURL + 'index.php'/* Zikula.Config.entrypoint */ + '?module=MUImage&type=external&func=finderImages&editor=xinha';

	    	MU(imagedialog).dialog({
	    		title: Zikula.__('Choose an image with a kind of inclusion!', 'module_muimage'),
	    		modal: true,
	    		width: 600,
	    		height: 400,
	    	    buttons: [
	    	  	        {
	    	  	        	text: Zikula.__('Reload albums', 'module_muimage'),
	    	  	        	click: LoadAlbums(editor, muimageURL)
	    	  	        },
	    	  	        {
	    	  	        	text: Zikula.__('Close', 'module_muimage'),
	    	  		        click: function() {
	    	  		        	MU(this).dialog('close');
	    	  		        }
	    	  	        }
	    	  	        ]
	    	});

	    	// datas from fields to js vars translate
	    	var mainalbum = MU("select[name=muimage-album]");
	    	var subalbum = MU("select[name=muimage-subalbum]");
	    	  
	    	// datas to string
	    	var data = 'mainalbum=' + mainalbum.val() + '&subalbum=' + subalbum.val();

	    	MU.ajax({
	    		type: 'GET',
	    		url: url2,
	    		success: function(ergebnis2) {
		    		if (ergebnis2) {
		    			MU(albumdialog).dialog('close');
		    			imagedialog.html(ergebnis2);
		    		} else {
		    			imagedialog.html('keine Bilder');
		    		}
		    	},
	    		data: data,
	    		cache: false
	    		});
	    	
	    	MU(".muimage-editor-plugin-image-slideshow", imagedialog).click(function(f) {
	    		f.preventDefault();
	    		var url3 = MU(this).attr('href');
	    	    MU.get(url3, function(ergebnis3) {
	    	    	if(ergebnis3) {
	    	    		alert('hallo');
	    	    	}
	    	    });	
	    	});
	    	}
	        
	        },
	    	{
	        text: Zikula.__('Close', 'module_muimage'),
	        click: function() {
	        	MU(this).dialog('close');
	        }
	        }]
	});
}