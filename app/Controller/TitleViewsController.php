<?php
App::uses('AppController', 'Controller');
//App::uses('CptComic', 'Model');
/**
 * TitleViews Controller
 *
 * @property CptComic $CptComic
 */
class TitleViewsController extends AppController {

    public $uses = array('SampleDatas');
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

}
