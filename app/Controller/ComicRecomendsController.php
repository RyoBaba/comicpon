<?php
App::uses('AppController', 'Controller');
//App::uses('CptComic', 'Model');
/**
 * ComicRecomends Controller
 *
 * @property CptComic $CptComic
 */
class ComicRecomendsController extends AppController {

    var $uses = array('ComicRecomends');
    var $components = array('Common');

	function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
	}

    function beforeFilter() {
        parent::beforeFilter();
        
    }

/**
 * public method 書籍検索条件入力
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
