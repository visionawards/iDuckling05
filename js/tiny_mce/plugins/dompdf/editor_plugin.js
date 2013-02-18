/**
 * $Id: editor_plugin_src.js 201 2007-02-12 15:56:56Z spocke $
 *
 * @author Moxiecode
 * @copyright Copyright © 2004-2008, Moxiecode Systems AB, All rights reserved.
 */

(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('dompdf');

	tinymce.create('tinymce.plugins.DomPdfPlugin', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceDomPdf');
			ed.addCommand('mceDomPdf', function() {								 
				
				// Build a form for POSTing bec. GET is not suitable for longer texts due to
				// maximum URL length
				var form  = document.createElement('form');
				var input = document.createElement('input'); 
							
				// Necessary attributes
				var form_id     = document.createAttribute('id');
				var form_action = document.createAttribute('action');
				var form_method = document.createAttribute('method');
				var form_target = document.createAttribute('target');
				var input_name  = document.createAttribute('name');
				var input_value = document.createAttribute('value');
	
				form_id.nodeValue     = 'dompdf_formid';
				form_action.nodeValue = url + '/generatePdf.php';
				form_method.nodeValue = 'post';
				form_target.nodeValue = '_blank';								
				input_name.nodeValue  = 'dompdf_html';
				input_value.nodeValue = tinyMCE.activeEditor.getContent();
			
				form.setAttributeNode(form_id);
				form.setAttributeNode(form_action);
				form.setAttributeNode(form_method);
				form.setAttributeNode(form_target);
				input.setAttributeNode(input_name);
				input.setAttributeNode(input_value);
				
				form.appendChild(input);
				document.getElementsByTagName('body')[0].appendChild(form);				
														
				// Submit html
				document.getElementById('dompdf_formid').submit();		

				// Remove the form
				input.removeAttribute('name');
				input.removeAttribute('value');
				form.removeAttribute('action');					
				form.removeAttribute('method');					
				form.removeAttribute('target');					
				form.removeAttribute('id');					
	
				form.removeChild(input)
				document.getElementsByTagName('body')[0].removeChild(form);
			});

			// Register dompdf button
			ed.addButton('dompdf', {
				title : 'dompdf.desc',
				cmd : 'mceDomPdf',
				image : url + '/img/dompdf.gif'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('dompdf', n.nodeName == 'IMG');
			});
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'DomPdf plugin',
				author : 'Ralf Seliger',
				authorurl : 'http://kreidestaub.de',
				infourl : 'http://kreidestaub.de',
				version : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('dompdf', tinymce.plugins.DomPdfPlugin);
})();