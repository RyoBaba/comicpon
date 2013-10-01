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
				_players.push( {
					name: $('#playerName'+i).val(),
					url: $('#playerUrl'+i).val()
				} );
			}
console.log(_players);
			//GameStageにプレーヤー情報セット
			this.gameStage.players(_players);
			//GameStage上のプレーヤーにカードを配布し初期通信開始
			this.gameStage.initGame();
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