<?php
namespace Stafleu\Models;
class Exception extends \Exception implements \Stafleu\Interfaces\Model {

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\Model::__toString()
	 */
	public function __toString() {
		return $this->getMessage();
	} // __toString();

	public static function handler($exception) {
		restore_exception_handler();
		require BASEDIR . 'templates/exception.phtml';
	} // handler();

} // end class Exception

set_exception_handler(array('\Stafleu\Models\Exception', 'handler'));