<?php

$save_title_action = Router::url(array('controller'=>'SampleDatas', 'action'=>'save_title'));

/*
$script = <<<SCRIPT
	
	$(document).ready(function(){
		$('#inputData').click(function(){
		
		
		//alert("<!DOCTYPE html>aafjsdfjk;sldkflsdkf<bodyここここここここここ</body></html>".replace(/DOCTYPE.+\\<body/, ""))
		alert("<!DOCTYPE html>aafjsdfjk;sldkflsdkf<bodyここここここここここ</body></html>".replace(/\\/body.*$/, ""))
		
			_baseTxt = $('#base_html').val();
			_baseTxt = _baseTxt.replace(/[\\\\n\\\\r]/g, "");
			_baseTxt = _baseTxt.replace(/DOCTYPE.+\\<body/, "");
			_baseTxt = _baseTxt.replace(/\\/body.*$/, "");
			$('#outArea2').val(_baseTxt);
			
		});
	});
	
SCRIPT;
	
	$this->start('script');
	echo $this->Cp->scriptBlock($script);
	$this->end();
*/

	$this->Html->script('htmltextparse.js', array('inline' => false));	
?>
<script>
	$(document).ready(function(){
		$('#inputData').click(function(){
		
			_baseTxt = $('#base_html').val();
			_baseTxt = html_text_parse(_baseTxt);
			//$('#outArea2').val(_baseTxt);
			$('#outArea1').append( _baseTxt );
			
			setTimeout(function(){
				i=0;
				$('#mw-content-text h2').each(function(){
					t = $(this).text();
					if(!t.match(/目次/)){
						vowel = t.replace(/\[編集\]/, "").replace(/ /g, "");
						nextUl = $(this).next();
						u = "";
						$('li', nextUl).each(function(){
							title = $('a', this).attr('title');
							wikiUrl = $('a', this).attr('href');
							description = $(this).text();
							u += "<input type='hidden' name='vowel[" + i + "]' value='" + vowel + "'>　"
							   + "<input type='hidden' name='href[" + i + "]' value='" + wikiUrl + "'>"
							   + "<input type='hidden' name='title[" + i + "]' value='" + title + "'>　"
							   + "<input type='hidden' name='description[" + i + "]' value='" + description + "'>　";
							   i++;
						});
						$('#outArea2').append(u);
					}
					
					
					
				});
			}, 250);
			
		});
	});
</script>


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

</style>


<h1>Wikipediaの日本の漫画タイトルまとめページからHTML解析し情報取得</h1>

<div id="inArea">
	<textarea id="base_html" rows="5" cols="80" ><?php echo $wikidatas; ?>
	</textarea><br>
	<input type="button" id="inputData" value="ベースHTML取り込み">
</div>

<form action="<?php echo $save_title_action; ?>" id="SaveForm" method="post">
	<div id="outArea1"></div>
	<div id="outArea2"></div>
	<input type="submit" value="タイトル情報をマスタに保存する">
</form>

