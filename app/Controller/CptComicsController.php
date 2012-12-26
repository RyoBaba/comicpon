<?php
App::uses('AppController', 'Controller');
/**
 * CptComics Controller
 *
 * @property CptComic $CptComic
 */
class CptComicsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CptComic->recursive = 0;
		$this->set('cptComics', $this->paginate());
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
