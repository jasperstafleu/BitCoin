<?php
namespace Events;

class Form implements \Interfaces\Event {

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\Event::trigger()
	 */
	public static function trigger(array $path = array(), array $request = array(), $enacter = 'program') {
		$whichForm = array_shift($path);
		self::$whichForm($path, $request, $enacter);
	} // trigger();

	/**
	 * Handle the main form.
	 *
	 * @param array $path
	 * @param array $request
	 * @param string $enacter
	 */
	public static function main(array $path = array(), array $request = array(), $enacter = 'program') {
		$view = new \Views\Form();
		$view->std();
	} // main();

} // end class Form