<?php
App::uses('AppController', 'Controller');
//App::uses('CptComic', 'Model');
/**
 * TitleViews Controller
 *
 * @property CptComic $CptComic
 */
class TitleViewsController extends AppController {

    public $uses = array();
    public $components = array('Common', 'Session');
	public $helpers = array('Cp');

	function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
	}

	function beforeFilter() {
		parent::beforeFilter();
		
	}
	
	/**
	 * データ解析
	 */
	public function index () {
		
		//$wikidatas = $this->SampleDatas->getWikiDatas($vowelcode);
		
		//$this->set('wikidatas', $wikidatas);
		
	}
	
	public function search () {
		
		$params = $this->_get_search_params();
		
	}
	//(SUB)タイトル検索パラメタ取得
	private function _get_search_params(){
		
		$params = array();
		
		//ページ遷移／ソート順変更ならセッションから前の条件回復
		//$params['vowel_code']
		
	}

}
