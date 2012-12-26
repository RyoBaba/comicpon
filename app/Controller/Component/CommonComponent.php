<?php
/**
 * Common Component
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * Author b_b 2012.12.21
 */

//App::uses('Component', 'Controller');
//App::uses('Security', 'Utility');
//App::uses('Hash', 'Utility');

/**
 * Cookie Component.
 *
 * Cookie handling for the controller.
 *
 * @package       Cake.Controller.Component
 * @link http://book.cakephp.org/2.0/en/core-libraries/components/cookie.html
 *
 */
class CommonComponent extends Component {

/**
 * The name of the cookie.
 *
 * Overridden with the controller beforeFilter();
 * $this->Cookie->name = 'CookieName';
 *
 * @var string
 */
	public $name = 'Common';

/**
 * params 
 * コントローラのparamsプロパティを参照する（startupメソッドで転記）
 */
	public $params = array();

/**
 * Constructor
 *
 * @param ComponentCollection $collection A ComponentCollection for this component
 * @param array $settings Array of settings.
 */
	public function __construct(ComponentCollection $collection, $settings = array()) {
		//$this->key = Configure::read('Security.salt');
		parent::__construct($collection, $settings);
	}

/**
 * startup
 */
	public function startup (Controller $controller) {
		parent::startup($controller);
		$this->params = $controller->params;
		//pr($this->params);
	}

/**
 * public function Common
 * 各経路のクライアントリクエストパラメタを返す
 * 何となく優先順位
 * 1. GET
 * 2. POST(form)
 * 3. 名前付きパラメタ
 * ※該当のパラメタを検出できなかった場合、空文字を返す
 */
	public function getParam( $name ) {

		//[1]GETパラメタの取得
		if( isset($this->params->query[$name] ) ){
			return $this->params->query[$name];
		}
		
		//[2]POSTパラメタの取得
		if( isset($this->params->data[$name]) ) {
			return $this->params->data[$name];
		}

		//[3]名前付きパラメタの取得
		if( isset($this->params->named[$name]) ) {
			return $this->params->named[$name]; 
		}
		
		return "";
		
	}

}

