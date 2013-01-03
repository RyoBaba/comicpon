<?php
App::uses('AppController', 'Controller');
//App::uses('CptComic', 'Model');
/**
 * ComicRecomends Controller
 *
 * @property CptComic $CptComic
 */
class ComicRecomendsController extends AppController {

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
 * public method 書籍検索メニュー
 */
	public function index(){
	
	}

/**
 * public method 書籍ISBNダイレクト検索条件入力
 */
	public function search() {
	}


/**
 * public method 書籍検索結果
 *
 * @return void
 */
    public function result() {
        
        //[1]指定されたISBNコードを取得
        $isbn = $this->Common->getParam('isbn');

        //[2]サービスモデルの書籍コード検索メソッド（最初にマスタ参照し、該当無ければ楽天APIから取得を試みる）
        $item_data = $this->ComicRecomends->findBooks($isbn, "ISBN");
        $this->set('item_data', $item_data);
    }

/**
 * ジャンル検索
 */
	public function genre(){
		$genre_data = $this->ComicRecomends->getGenre("001001");
		$this->set("genre_data", $genre_data);
	}

/**
 * 特定ジャンルから書籍データを取得し、必要に応じマスタ登録
 */
	public function book_search_by_genre( $genre_id = "001001" ){
		//入力パラメタチェック
		$genre_data = array(
			'current' => array(),
			'children' => array()
		);
		$params = array('genre_id'=>$genre_id);
		$RakutenBookSearch = ClassRegistry::init('RakutenBookSearch');
		if( FALSE === $RakutenBookSearch->chk_params($params) ){
			$this->Session->setFlash(__('ジャンル指定が正しくありません'));
		} else {
			$genre_data = $this->ComicRecomends->getGenre($genre_id);
		}
		$this->set("genre_data", $genre_data);

	}

/**
 * 書籍検索入力（楽天ブックス由来）
 */
	public function book_search() {
		
	}
/**
 * 書籍検索結果（楽天ブックス由来）
 */
	public function book_list () {

		$item_datas = array();
		$RakutenBookSearch = ClassRegistry::init('RakutenBookSearch');
		
		//パラメタ取得
		$params = array();
		//ページチェンジ／ソートチェンジの場合、セッションから条件回復
		$page = $this->Common->getParam('page');
		$sort = $this->Common->getParam('srt');
		if( $page != "" ){
			$params = $this->Session->read('BookSearch');
			$params['page'] = $page; unset($page);			
		} else if( $sort != "" ) {
			$params = $this->Session->read('BookSearch');
			$params['sort'] = $sort;
		} else {
			$params['keyword'] = $this->Common->getParam('keyword');
			$params['isbn'] = $this->Common->getParam('isbn');
//			$this->Session->write('BookSearch', $params);
		}
		$this->Session->write('BookSearch', $params);
		//空の条件はAPIに渡すとエラーになるため破棄しておく
		foreach( $params as $key => $v ){
			if($v==""){
				unset($params[$key]);
			}
		}

		//パラメタ検査
		$result = $RakutenBookSearch->chk_params($params);
		if( FALSE === $result['flag'] ){
			$this->Session->setFlash(__( $result['msg'] ));
			$this->redirect("book_search");
		} else {
			if( FALSE === $item_datas_json = $this->ComicRecomends->getBookList($params) ){
				$this->Session->setFlash(__( "書籍情報を正常に取得できませんでした。" ));
				$this->redirect("book_search");
			} else {
				$item_datas = json_decode($item_datas_json, true);
			}
		}
		$this->set("item_datas_json", $item_datas_json);
		$this->set("item_datas", $item_datas);
	}


/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function view($id = null) {
        $this->CptComic->id = $id;
        if (!$this->CptComic->exists()) {
            throw new NotFoundException(__('Invalid cpt comic'));
        }
        $this->set('cptComic', $this->CptComic->read(null, $id));
    }

/**
 * add method
 *
 * @return void
 */
    public function add() {
        if ($this->request->is('post')) {
            $this->CptComic->create();
            if ($this->CptComic->save($this->request->data)) {
                $this->Session->setFlash(__('The cpt comic has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The cpt comic could not be saved. Please, try again.'));
            }
        }
    }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function edit($id = null) {
        $this->CptComic->id = $id;
        if (!$this->CptComic->exists()) {
            throw new NotFoundException(__('Invalid cpt comic'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->CptComic->save($this->request->data)) {
                $this->Session->setFlash(__('The cpt comic has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The cpt comic could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->CptComic->read(null, $id);
        }
    }

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->CptComic->id = $id;
        if (!$this->CptComic->exists()) {
            throw new NotFoundException(__('Invalid cpt comic'));
        }
        if ($this->CptComic->delete()) {
            $this->Session->setFlash(__('Cpt comic deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Cpt comic was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
}
