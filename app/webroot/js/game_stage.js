//定数
 //スート定数
var HAERT = 0, SPADE = 1, CLUB = 2, DIA = 3, JOKER = 4;
//カード雛形
var CARDS = [
	[1,2,3,4,5,6,7,8,9,10,11,12,13],
	[1,2,3,4,5,6,7,8,9,10,11,12,13],
	[1,2,3,4,5,6,7,8,9,10,11,12,13],
	[1,2,3,4,5,6,7,8,9,10,11,12,13],
	[1,2]	//ジョーカースートのみ数字に意味は無し
];
//プレーヤー最小人数
var PLAYER_MIN_COUNT = 2;
//プレーヤー最大人数
var PLAYER_MAX_COUNT = 10;
//カード所持状態コード（0:未所持, 1:所持, 9:場に捨てられている)
var HAVE_STAT_NO = 0, HAVE_STAT_YES = 1, HAVE_STAT_DROP = 9;
//通信タイプ (1:初期通信, 2:手番, 9:ゲーム終了)
var REQ_TYPE_START = 1, REQ_TYPE_TURN = 2, REQ_TYPE_END = 9;


/*
 * [M]GameStage クラス
 */
//var GameStage = function(){};

var GameStage = (function(){

	//return Object
	return {

		/*
		 * Properties
		 */
		game_id : null,				//ゲームID
		player_cnt : 0,		//プレーヤー人数
		players_arr : new Array(),	//プレーヤー配列
		player_card_arr: new Array(), 	
		deck : new Array(),	//デッキ：デッキ枚数分の要素数を持つ配列（各要素は全てCardのインスタンスとする）
		card_cnt: 0,

		/*
		 * Methods
		 */	
		// 初期化（ゲームID, デッキ）
		init : function() {
			this.setGameId();
			this.player_cnt = 2;	//初期値は２
			this.initCard();
			this.shuffleCard();
		},
		initCard : function () {
			this.deck = new Array();
			//カード定義順にデッキにカードを配列する
			for( var suit=0; suit<=4; suit++ ){
				for( var _idx in CARDS[suit] ) {
					this.deck.push( new Card(suit, CARDS[suit][_idx]) );
					this.card_cnt++;
				}
			}
		},

		//(SUB)カードシャッフル
		shuffleCard :function () {
			for(i=0; i<=53; i++){
				w = this.deck[i];
				r = Math.floor(Math.random()*(13*4+2));
				this.deck[i] = this.deck[r];
				this.deck[r] = w;
			}
		},
		setGameId : function() { this.game_id = new Date().getTime(); },
		getGameId : function() { return this.game_id; },
		playerCnt : function(_cnt) { 
			if(typeof _cnt != "undefined"){
				this.player_cnt = _cnt; 
			}
			return this.player_cnt;
		},
		//playerIdを受け取り、プレイヤー配列のインデックス番号を返す
		playerIdx : function( playerId ) {
			for( var idx in this.players_arr ) {
				if( this.players_arr[idx].id == playerId ) {
					return idx;
				}
			}
			return false;
		},
		players : function(_players){
			if(typeof _players != "undefined"){
				this.players_arr = new Array();
				for(var i in _players){
					this.players_arr.push( new Player(this.game_id, _players[i].name, _players[i].url) );
				}
			}
			return this.players_arr;
		},
		initGame : function() {
			//[1]プレーヤーにカードを配布
			var _player_idx = 0;
			for(var i = 0; i < this.card_cnt; i++ ){
				tmp = this.deck[i];
				tmp.have = HAVE_STAT_YES;
				this.players_arr[_player_idx].cards.push( tmp );
				_player_idx = ((_player_idx + 1) == this.player_cnt) ? 0 : _player_idx + 1;
			}
			//[2]各プレーヤーのAPIにカード情報をPOST送信
console.dir(this.players_arr[0]);

			for( var i in this.players_arr ){
				var rtn_data = this.initAjaxSend( this.players_arr[i] );
				this.players_arr[i].turn1Url = rtn_data.turn1Url;
				this.players_arr[i].turn2Url = rtn_data.turn2Url;
				this.players_arr[i].endUrl = rtn_data.endUrl;
			}

console.dir(this.players_arr[0]);
console.dir(this.players_arr[1]);

			//[3]ゲーム開始待機状態へ
		},
		initAjaxSend : function( playerData ) {
			var postData = {
				type : REQ_TYPE_START,	//通信タイプ
				info : playerData,		//プレーヤーデータ
				rule : new Array()		//特殊ルールフラグ
			};
			var rtn_data = new Array();
			(function(){
				$.ajax({
					url      : playerData.url,
					type     : "POST",
					data     : postData,
					timeout  : 5000,
					jsonpCallback: "callback",
					dataType : "jsonp",
					async    : false,
					/*
					success: function( data, playerData ){
						var script = document.createElement('script');
						script.src = 
						rtn_data.turn1Url = data.info.turn1Url;
						rtn_data.turn2Url = data.info.turn2Url;
						rtn_data.endUrl = data.info.endUrl;
					},
					*/
					error  : function( e ) {
					}
				})
				.done(function(data){
					if(data){
						console.log('[Using jQuery.ajax function case] '+data);
					}
				})
				.fail(function(jqXHR,textStatus,errorThrown){
					console.log('['+textStatus+'] '+errorThrown);
				});
			})();
			return rtn_data;

		},

		__DMY : null


		//---- ゲーム中処理群 ------------------------

		//---- ゲーム終了処理群-----------------------
	};

});

/*=======================================================
 	MODELS
 =======================================================*/
/*
 * Card
 */
var Card = function(suit, num, have) {
	have = have || HAVE_STAT_NO;
	this.suit = suit;
	this.num = num;
	this.have = have;
	return this;
};
/*
 * Player
 */
var Player = function(id,name,url){
	
	//プレーヤー基本情報
	this.id = id;
	this.name = name;

	//プレーヤー通信用情報
	this.url = url;
	this.turn1Url = null;
	this.turn2Url = null;
	this.endUrl = null;

	//プレーヤーゲーム内状態情報
	this.cards = new Array();
	return this;
}
/*
 * Flow
 */
var Flow = function() {
	this.ACTION_HAND = "hand";
	this.ACTION_PASS = "pass";
	this.player_id = null;
	this.action = null;
	this.card = null;
	this.init = function() {

	}
}



