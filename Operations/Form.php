<?php
namespace Operations;

class Form implements \Interfaces\Operation {

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\Operation::run()
	 */
	public function run(\Interfaces\Model $model, array $req = array()) {
		$model->setRequest($req);
	} // run();

} // end class Main