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
		}
	};
})( jQuery );


/*
var GameStageView = new function() {};
GameStageView.prototype.
*/