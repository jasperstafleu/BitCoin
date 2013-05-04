<?php
namespace Stafleu\Events;

final class Dispatcher implements \Stafleu\Interfaces\Event {

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\Event::trigger()
	 */
	public static function trigger(array $path = array(),
			array $request = array(), $enacter = 'program') {
		if ( !$realEvent = ucfirst(array_shift($path)) ) {
			$realEvent = 'Form';
			$path = array('main');
		}
		call_user_func_array(
				array('\\Stafleu\\Events\\' . $realEvent, 'trigger'),
				array($path, $request, 'user')
		);
	} // trigger();

} // end class Dispatcher