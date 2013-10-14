<?php
App::uses('AppController', 'Controller');
//App::uses('CptComic', 'Model');
/**
 * ComicRecomends Controller
 *
 * @property CptComic $CptComic
 */
class GameStageController extends AppController {

    public $uses = array('GameStage');
    public $components = array('Common', 'Session', 'RequestHandler');
	public $helpers = array('Cp');
	public $aj_actions = array('stub0','stub1', 'stub2', 'stub3');
	

	function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
	}

    function beforeFilter() {
        parent::beforeFilter();
        //Ajax通信でJSONを返すタイプのアクションの場合の前処理
        // --> Ajax check remove 131014 bb
 		if( /* $this->RequestHandler->isAjax() && */ in_array($this->action, $this->aj_actions) ){
			Configure::write('debug', 0);
			$this->layout = "ajax";
			$this->RequestHandler->setContent('json');
			$this->RequestHandler->respondAs('application/json; charset=UTF-8');
		}       
    }

/**
 * public method ゲームステージTOP
 */
	public function index(){
		$this->layout = "game_stage";
		

	}
/**
 * public 通信テスト用スタブ（0）：初期通信
 */
	public function stub0() {

		//POSTデータ受け取り
		$receiveData = array();

		$receiveData['type'] = $this->Common->getParam('type');
		$receiveData['info'] = $this->Common->getParam('info');
		$receiveData['rule'] = $this->Common->getParam('rule');

		//ゲーム進行中通信用アクションパスを付記する
		$responseData = $receiveData; unset($receiveData);
		$responseData['info']['turn1Url'] = "/comicpon/GameStage/stub1";
		$responseData['info']['turn2Url'] = "/comicpon/GameStage/stub2";
		$responseData['info']['endUrl'] = "/comicpon/GameStage/stub3";

		$this->_renderJson( $responseData );

	}


}
