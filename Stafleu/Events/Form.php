<?php
namespace Stafleu\Events;

class Form implements \Stafleu\Interfaces\Event {

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\Event::trigger()
	 */
	public static function trigger(array $path = array(), array $request = array(), $enacter = 'program') {
		if ( !($whichForm = array_shift($path)) ) {
			$whichForm = 'main';
		}
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
		$form = new \Stafleu\Models\Forms\Main;
		$operation = new \Stafleu\Operations\Form();
		$operation->run($form, $request);
		$view = new \Stafleu\Views\Form();
		$view->std($form);
	} // main();

} // end class Form