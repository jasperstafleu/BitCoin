<?php
namespace Models;
class Exception extends \Exception implements \Interfaces\Model {

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\Model::__toString()
	 */
	public function __toString() {
		return $this->getMessage();
	} // __toString();

	public static function handler($exception) {
		restore_exception_handler();
		require BASEDIR . 'templates/exception.phtml';
	} // handler();

} // end class Exception

set_exception_handler(array('\Models\Exception', 'handler'));