<?php
error_reporting(-1);
//GZIP the file and set the JavaScript header
ob_start("ob_gzhandler");
header("Content-type: text/javascript");

//print_r($_SERVER);

/*$dir    = $_SERVER['DOCUMENT_ROOT'].'/BC';
$files1 = scandir($dir);
$files2 = scandir($dir, 1);

print_r($files1);
print_r($files2);  */


require_once( $_SERVER['DOCUMENT_ROOT'].'/'.htmlspecialchars($_GET['dir']).'/wp-config.php' );


//print DB_USER.'.'.DB_PASSWORD.'.'.DB_NAME.''.DB_HOST; 

/* create a new connection */
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
 



//$relacje = array();

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje";  
$res = $wpdb->get_results("SELECT `ID`, `Gosp`, `Gosc`, `Kategoria`, `Status`, `Data`, `PktGosp`, `PktGosc`, `Rozgrywki` FROM $RELACJE WHERE `Kategoria` != 'Losowanie' and `Kategoria` != 'Multirelacja' ORDER BY `data` DESC");
$relacje = array();
 $relacje[] = (object) array('text' => 'Wybierz', 'value' => 'default');  
foreach ($res as $rs) 
{
if($rs->Gosc != "") $TEXT = $rs->Kategoria.": ".$rs->Gosp." vs ".$rs->Gosc; else $TEXT = $rs->Kategoria.": ".$rs->Rozgrywki;
			 $relacje[] = (object) array('text' => $TEXT, 'value' => $rs->ID);   
}
$REL = json_encode($relacje,JSON_UNESCAPED_UNICODE );
if($REL == "") $REL = '[]';

?>
                               

  (function() {
	tinymce.PluginManager.add('bs3_panel', function( editor, url ) {
		var sh_tag = 'showLive';

		//helper functions 
		function getAttr(s, n) {
			n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
			return n ?  window.decodeURIComponent(n[1]) : '';
		};

		function html( cls, data ,con) {
			var placeholder = url + '/img/' + getAttr(data,'type') + '.jpg';
			data = window.encodeURIComponent( data );
			content = window.encodeURIComponent( con );

			return '<img src="' + placeholder + '" class="mceItem ' + cls + '" ' + 'data-sh-attr="' + data + '" data-sh-content="'+ con+'" data-mce-resize="false" data-mce-placeholder="1" />';
		}

		function replaceShortcodes( content ) {
			return content.replace( /\[bs3_panel([^\]]*)\]([^\]]*)\[\/bs3_panel\]/g, function( all,attr,con) {
				return html( 'wp-bs3_panel', attr , con);
			});
		}

		function restoreShortcodes( content ) {
			return content.replace( /(?:<p(?: [^>]+)?>)*(<img [^>]+>)(?:<\/p>)*/g, function( match, image ) {
				var data = getAttr( image, 'data-sh-attr' );
				var con = getAttr( image, 'data-sh-content' );

				if ( data ) {
					return '<p>[' + sh_tag + data + ']' + con + '[/'+sh_tag+']</p>';
				}
				return match;
			});
		}

		//add popup
		editor.addCommand('bs3_panel_popup', function(ui, v) {
			//setup defaults
			var header = '';
			if (v.header)
				header = v.header;
			var footer = '';
			if (v.footer)
				footer = v.footer;
			var type = 'default';
			if (v.type)
				type = v.type;
			var content = '';
			if (v.content)
				content = v.content;

			editor.windowManager.open( {
				title: 'Dodaj wynik spotkania',
				body: [
					{
						type: 'listbox',
						name: 'type',
						label: 'Relacja',
						value: type,
						'values': <?=$REL?>,
						tooltip: 'Wybierz spotkanie'
					},
          {
						type: 'listbox',
						name: 'time',
						label: 'Typ',
						value: type,
						'values': [{ text: 'Początek', value: 'start'},{ text: 'Koniec', value: 'koniec'}],
						tooltip: 'Wybierz rodzaj'
					},
				],
				onsubmit: function( e ) {
					var shortcode_str = '[' + sh_tag + ' id="'+e.data.type+'" typ="'+e.data.time+'"]';
	
					//insert shortcode to tinymce
					editor.insertContent( shortcode_str);
				}
			});
	      	});

		//add button
		editor.addButton('bs3_panel', {
			icon: 'bs3_panel',
			tooltip: 'Dodaj wynik spotkania',
			onclick: function() {
				editor.execCommand('bs3_panel_popup','',{
					header : '',
					footer : '',
					type   : 'default',
					content: ''
				});
			}
		});

		//replace from shortcode to an image placeholder
		editor.on('BeforeSetcontent', function(event){ 
			event.content = replaceShortcodes( event.content );
		});

		//replace from image placeholder to shortcode
		editor.on('GetContent', function(event){
			event.content = restoreShortcodes(event.content);
		});

		//open popup on placeholder double click
		editor.on('DblClick',function(e) {
			var cls  = e.target.className.indexOf('wp-bs3_panel');
			if ( e.target.nodeName == 'IMG' && e.target.className.indexOf('wp-bs3_panel') > -1 ) {
				var title = e.target.attributes['data-sh-attr'].value;
				title = window.decodeURIComponent(title);
				console.log(title);
				var content = e.target.attributes['data-sh-content'].value;
				editor.execCommand('bs3_panel_popup','',{
					header : getAttr(title,'header'),
					footer : getAttr(title,'footer'),
					type   : getAttr(title,'type'),
					content: content
				});
			}
		});
	});
})();

<?php
//Flush the output buffer
ob_end_flush();
?>
