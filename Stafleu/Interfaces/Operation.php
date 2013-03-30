<?php
namespace Stafleu\Interfaces;

interface Operation {

	/**
	 * Run the operation upon the $model, as based on the request $req
	 * @param \Stafleu\Interfaces\Models $model	The model to run the operation upon
	 * @param array $req								The request passed along with the operation
	 */
	public function run(\Stafleu\Interfaces\Model $model, array $req = array());

} // end interface Operation