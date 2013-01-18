<?php
App::uses('AppController', 'Controller');
//App::uses('CptComic', 'Model');
/**
 * ComicRecomends Controller
 *
 * @property CptComic $CptComic
 */
class SampleDatasController extends AppController {

    public $uses = array('ComicRecomends');
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
	
	}

}
