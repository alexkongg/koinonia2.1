var GPVideoDialog = {
	preInit : function() {
		var url;

		tinyMCEPopup.requireLangPack();

		if (url = tinyMCEPopup.getParam("external_image_list_url"))
			document.write('<script language="javascript" type="text/javascript" src="' + tinyMCEPopup.editor.documentBaseURI.toAbsolute(url) + '"></script>');
	},

	init : function(ed) {
		var f = document.forms[0], nl = f.elements, ed = tinyMCEPopup.editor, dom = ed.dom, n = ed.selection.getNode();

		tinyMCEPopup.resizeToInnerSize();
		this.fillClassList('class_list');
		this.fillFileList('src_list', 'tinyMCEImageList');
		this.fillFileList('over_list', 'tinyMCEImageList');
		this.fillFileList('out_list', 'tinyMCEImageList');
		TinyMCE_EditableSelects.init();
	},
	
	insert : function(file, title) {
		var ed = tinyMCEPopup.editor, t = this, f = document.forms[0];
		var shortcode = '[video ';
		
		if (f.gpvimeoid.value != "")
			shortcode = shortcode + ' id="' + f.gpvimeoid.value + '"';
		if (f.gpwidth.value != "")
			shortcode = shortcode + ' width="' + f.gpwidth.value + '"';
		if (f.gpheight.value != "")
			shortcode = shortcode + ' height="' + f.gpheight.value + '"';
		else
			shortcode = shortcode + "]";
		
		ed.execCommand('mceInsertContent', false, shortcode, {skip_undo : 1});
		tinyMCEPopup.close();
	},
};

GPVideoDialog.preInit();
tinyMCEPopup.onInit.add(GPVideoDialog.init, GPVideoDialog);