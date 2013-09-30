var GameStageView = (function( $ ) {
	return {
		init :function(){
			console.log("GameStageView init!!");
			this.openConfig();
			return;
		},
		//設定入力エリア表示
		openConfig: function(){
			$('#GameStage_config_box').fadeIn();
		},
		//設定入力エリア消去
		closeConfig: function() {
			$('#GameStage_config_box').fadeOut();
		},
		playerInfoArea : function(playerCnt){
			_html = "";
			for(var i=1; i<=playerCnt; i++){
				_html += "<fieldset><legend>プレーヤー" + i + "</legend>" 
					+ "NAME:<input type='text' id='playerName"+i+"' value=''>"
					+ "　　　URL:<input type='text' id='playerUrl"+i+"' value=''><br>"
					+ "</fieldset>"
			}
			_html += "<input type='button' id='submitPlayerInfo' value='プレーヤー情報入力完了'>";
			$('#playerSetArea').append(_html);
			
		},
		__DMY: null
	};
})( jQuery );


/*
var GameStageView = new function() {};
GameStageView.prototype.
*/