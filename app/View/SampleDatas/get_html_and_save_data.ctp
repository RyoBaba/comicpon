<?php

$get_html_action = Router::url(array('controller'=>'SampleDatas', 'action'=>'aj_get_wiki_html'));
$save_html_action = Router::url(array('controller'=>'SampleDatas', 'action'=>'aj_save_wiki_html'));

$script = <<<SCRIPT
 	//タイトル詳細情報へのURL一覧
	var ids = {$ids};
	var isDev = false, devSaveCnt = 5000;
	
	var saveTitleTextData = (function(ids_idx, id, text){
		var idx = false;
		return function(ids_idx, id, text) {
			if(isDev) console.log('save start !!');
			idx = ids_idx;
			if(idx === false) return false;
			var data = {
				title_mas_id: id,
				data_text: text
			};
			$.ajax({
				type: "POST",
				assync: false,
				url: '{$save_html_action}',
				data: data,
				dataType: 'json',
				success: function(json) {
					if(json.flag){
						if(ids.length > idx){
							if(idx >= devSaveCnt-1 && isDev) return false; //開発環境では指定件数で処理中断
							//console.log("chk3");
							getDomDocument();
						} else {
							//console.log("chk2");
							return false;
						}
					} else {
						//console.log("chk1");
						return false;
					}
				}
			});
		};
	})();
	
	var getDomDocument = (function(){
		var idx = 0;
		return function(){
			$.ajax({
				type: "GET",
				assync: false,
				url: '{$get_html_action}/'+ids[idx],
				success: function(data){
					data = html_text_parse(data);
					$('#SandBox').empty().append(data);
					textNode = $('#SandBox #content').text();
					//textNode = textNode.substr(200,200);
					//$('#Result').append(textNode);
					if(isDev) console.log('text get finish!!');
					saveTitleTextData(idx, ids[idx], textNode);
					idx++;


/*
					if(ids.length > idx){
						getDomDocument();
					} else {
						return false;
					}
*/
				}
			});
			
		};
	})();
	
	function init() {
		//if( ("http://localhost.com").match(/localhost/i)) alert("OK");
		var loc = location.href + " ";
		if(loc.match(/localhost/i)){
			isDev = true;
		}
	}
	
	$(document).ready(function(){
		init();
		getDomDocument();
	});
  
SCRIPT;
	
    $this->start('script');
    echo $this->Cp->scriptBlock($script);
    $this->end();
    
    
    $this->Html->script('htmltextparse.js', array('inline' => false));	
?>

<style type="text/css">
#inArea {
	padding: 12px;
	border-bottom: solid 1px #CCC;
}

#outArea1 {
	height: 20px;
	overflow: hidden;
	background-color: #FFCCCC;
}
#outArea2 {
	height: 10px;
	overflow: hidden;
	background-color: #CCCCFF;
}
#SandBox {
	height: 10px;
	background-color: #FFCCCC;
	overflow: hidden;
}
</style>


<h1>Wikipediaの各タイトル別詳細ページより、当該タイトルの詳細情報を取得する</h1>
<div id='SandBox'></div>
<div id='Result'></div>

