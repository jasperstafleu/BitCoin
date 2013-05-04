<?php
namespace Stafleu\Models;

class Exception extends \Exception implements \Stafleu\Interfaces\Model {

    /**
     * Handler for exceptions.
     *
     * @see set_exception_handler
     * @param unknown $exception
     */
    public static function handler(\Exception $exception) {
        restore_exception_handler();
        // TODO: Something with sending mails to admin
        require BASEDIR . 'templates/exception.phtml';
    } // handler();

    /**
     * (non-PHPdoc)
     * @see \Stafleu\Interfaces\Model::__toString()
     */
    public function __toString() {
        return $this->getMessage();
    } // __toString();


} // end class Exception

set_exception_handler(array('\Stafleu\Models\Exception', 'handler'));