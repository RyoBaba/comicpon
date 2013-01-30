<?php
App::uses('AppController', 'Controller');
//App::uses('CptComic', 'Model');
/**
 * TitleViews Controller
 *
 * @property CptComic $CptComic
 */
class TitleViewsController extends AppController {

    public $uses = array('CptTitleMas');
    public $components = array('Common', 'Session', 'Paginator');
	public $helpers = array('Cp');
    public $paginate = array (
        'CptTitleMas'=>array(
        	'limit' => 10,
        	'sort' => 'id',
        ),
    );

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
		
		$conditions = array();
		if( $params['vowel'] != '' ){
			$conditions['vowel'] = $params['vowel'];
		}
		
		$title_data = $this->Paginator->paginate('CptTitleMas', $conditions);
		$this->set('title_data', $title_data);
		
	}
	//(SUB)タイトル検索パラメタ取得
	private function _get_search_params(){
		
		$params = array();
		
		$params['vowel'] = $this->Common->getParam('vowel');
		//ページ遷移／ソート順変更ならセッションから前の条件回復
		//$params['vowel_code']
		
		return $params;
		
	}

}
