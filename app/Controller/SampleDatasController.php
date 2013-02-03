<?php
App::uses('AppController', 'Controller');
//App::uses('CptComic', 'Model');
/**
 * ComicRecomends Controller
 *
 * @property CptComic $CptComic
 */
class SampleDatasController extends AppController {

    public $uses = array('SampleDatas');
    public $components = array('Common', 'Session', 'RequestHandler');
	public $helpers = array('Cp', 'Js');
	public $aj_actions = array('aj_get_wiki_html','aj_save_wiki_html');
	
	function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
	}

	function beforeFilter() {
		parent::beforeFilter();
		if( $this->RequestHandler->isAjax() && in_array($this->action, $this->aj_actions) ){
			Configure::write('debug', 0);
			$this->layout = false;
			$this->RequestHandler->setContent('json');
			$this->RequestHandler->respondAs('application/json; charset=UTF-8');
		}
	}
	
	/**
	 * データ解析
	 */
	public function index ($vowelcode) {
		
		$wikidatas = $this->SampleDatas->getWikiDatas($vowelcode);
		
		$this->set('wikidatas', $wikidatas);
		
	}
	
	public function save_title () {

		if( false === ini_set('max_input_vars', '12000') ){
			$this->log('ini_set failed!! ', LOG_DEBUG);
		}
		
		$datas = $this->_getSaveParam();
		$rtn = $this->SampleDatas->saveTitleMas($datas);
		
		$this->set('rtn', $rtn);
		
	}
	//(SUB)
	private function _getSaveParam() {
		
		$datas = array();
		$datas['title'] = $this->Common->getParam('title');
		$datas['description'] = $this->Common->getParam('description');
		$datas['vowel'] = $this->Common->getParam('vowel');
		$datas['wikiurl'] = $this->Common->getParam('href');

		return $datas;
		
	}
	
	/**
	 * タイトル詳細情報取得＆保存
	 */
	public function get_html_and_save_data(){
		$ids = $this->SampleDatas->getTitleIds();
		$ids = json_encode($ids);
		$this->set('ids', $ids);
	}
	
	/**
	 * (AjaxOnly) 指定されたURLのHTMLデータを取得し返す
	 */
	public function aj_get_wiki_html($id){
		
		//[1]HTMLデータを取得
		$data = $this->SampleDatas->getHtmlData($id);
		//$this->_renderJson($data, array('header'=>false, 'debugOff'=>true));
		
		$this->_renderPlain($data);
		
	}
	/**
	 * (AjaxOnly) 指定されたタイトルの詳細情報をテキストを保存する
	 *            ※既存のレコードが存在すれば、上書き保存する
	 */
	public function aj_save_wiki_html(){
		
		
		
		//[1]HTMLデータを取得
		$data = array(
			'title_mas_id' => $this->Common->getParam('title_mas_id'),
			'data_text' => $this->Common->getParam('data_text')
		);
	
		$this->SampleDatas->save_title_desc_text($data);
		
		$rtn = array('flag'=>true);
		$this->_renderJson($rtn);
		
	}
}
