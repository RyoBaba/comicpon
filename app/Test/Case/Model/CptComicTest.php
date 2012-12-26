<?php
App::uses('CptComic', 'Model');

/**
 * CptComic Test Case
 *
 */
class CptComicTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cpt_comic'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CptComic = ClassRegistry::init('CptComic');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CptComic);

		parent::tearDown();
	}

}
