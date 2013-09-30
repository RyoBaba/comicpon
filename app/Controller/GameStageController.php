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
    public $components = array('Common', 'Session');
	public $helpers = array('Cp');

	function __construct($request = null, $response = null) {
		parent::__construct($request, $response);

	}

    function beforeFilter() {
        parent::beforeFilter();
        
    }

/**
 * public method ゲームステージTOP
 */
	public function index(){
		$this->layout = "game_stage";
		

	}



}
