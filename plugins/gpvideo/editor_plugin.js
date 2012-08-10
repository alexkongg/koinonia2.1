/**
 * editor_plugin_src.js
 *
 * Copyright 2011, Gracepoint: Brian Wang
 *
 */

(function() {
	tinymce.create('tinymce.plugins.GPVideoPlugin', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mceGPVideoPlugin', function() {
				ed.windowManager.open({
					file : url + '/video.htm',
					width : 480 + parseInt(ed.getLang('advimage.delta_width', 0)),
					height : 160 + parseInt(ed.getLang('advimage.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register buttons
			ed.addButton('gpvideo', {
				title : 'Gracepoint Video',
				cmd : 'mceGPVideoPlugin',
				image : '../wp-content/plugins/gpvideo/img/video.gif'
			});
		},

		getInfo : function() {
			return {
				longname : 'Gracepoint Video',
				author : 'Brian Wang',
				authorurl : 'http://www.acts2fellowship.org/riverside',
				infourl : 'http://www.acts2fellowship.org/riverside',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('gpvideo', tinymce.plugins.GPVideoPlugin);
})();