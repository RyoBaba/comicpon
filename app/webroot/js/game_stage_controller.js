/*
 * [C]GameStageConroller
 */
var GameStageController = (function(){

	/*
	 * Local
	 */
	var jQs = {
		GameStage_config_box: null
		, mainBox: null
	};

	return {
		/*
		 * Properties
		 */
		gameStage : null, 

		/*
		 * Mthods
		 */
		openBox : function(selector){
			$('.stageParts').each(function(){
				var thisId = selector.attr('id');
				if($(this).attr('id')==thisId){
					$(this).slideDown();
				} else {
					$(this).slidUp();
				}
			});
		},

		/*
			画面読み込み時初期処理
			-- GameStageオブジェクトを生成し、ゲームID発行／デッキの初期化
			-- Playerエントリーフォーム(configBox)をオープン
		*/
		init : function(){

			console.log("GameStageController start!!");
			
			//セレクタキャッシュ一括取得
			for(var strId in jQs){
				jQs.strId = $('#'+strId);
			}

			//GameStage インスタンス生成
			this.gameStage = new GameStage();
			this.gameStage.init();


			//configBoxオープン
		},


		setPlayerCnt : function(){
			return this.gameStage.playerCnt(_cnt);
		},
		setPlayerInfo : function() {
			_players = new Array();
			for(var i=1; i<=this.gameStage.playerCnt(); i++ ){

console.log($('#playerName'+i).val());
console.log($('#playerUrl'+i).val());

				_players.push( {
					name: $('#playerName'+i).val(),
					url: $('#playerUrl'+i).val()
				} );
			}
			this.gameStage.players(_players);
		},
		__DMY: null
	}

})();


$(document).ready(function(){

	//ページ読み込み時初期処理
	GameStageController.init();
	GameStageView.init();

	//設定ウィンドウ周り
	$('#submitConfig').click(function(){
		_cnt = ~~$('#player_cnt').val();
		if(_cnt > 1 && _cnt < 10) {
			GameStageView.playerInfoArea( GameStageController.setPlayerCnt(_cnt) );
		} else {
			alert("人数は２人以上10人未満です");
		}
	});
	$('#submitPlayerInfo').live('click', function(){
		GameStageController.setPlayerInfo();
	});


});