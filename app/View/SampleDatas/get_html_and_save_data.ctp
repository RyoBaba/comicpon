<?php

$get_html_action = Router::url(array('controller'=>'SampleDatas', 'action'=>'aj_get_wiki_html'));

$script = <<<SCRIPT
 	//タイトル詳細情報へのURL一覧
	var ids = {$ids};
	
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
					textNode = textNode.substr(200,200);
					$('#Result').append(textNode);
					idx++;
if(idx > 10) return false;
					if(ids.length > idx){
						getDomDocument();
					} else {
						return false;
					}
				}
			});
			
		}
	})();
	
	$(document).ready(function(){
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

