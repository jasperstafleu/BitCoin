<?php
namespace Stafleu\Operations;

class Form implements \Stafleu\Interfaces\Operation {

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\Operation::run()
	 */
	public function run(\Stafleu\Interfaces\Model $model, array $req = array()) {
		if ( !$model->validate($req) ) {
			unset($req['step']);
		}
		$model->setRequest($req);
	} // run();

} // end class Form