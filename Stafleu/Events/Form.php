<?php
namespace Stafleu\Events;

class Form implements \Stafleu\Interfaces\Event {

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\Event::trigger()
	 */
	public static function trigger(array $path = array(),
			array $request = array(), $enacter = 'program') {
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
	public static function main(array $path = array(),
			array $request = array(), $enacter = 'program') {
		$operation = new \Stafleu\Operations\Form();

		if ( !empty($_SESSION[__METHOD__])
					&& !empty($_POST['formtoken'])
					&& !empty($_SESSION[__METHOD__][$_POST['formtoken']])
		) {
			$form = $_SESSION[__METHOD__][$_POST['formtoken']];
			if ( $form->formtoken->validate($_POST['formtoken']) ) {
				$operation->run($form, $_POST);
			} else {
				unset($form);
			}
		}

		if ( !isset($form) ) {
			$form = new \Stafleu\Models\Forms\Main();
			if ( empty($_SESSION[__METHOD__]) ) {
				$_SESSION[__METHOD__] = array();
			}
			$_SESSION[__METHOD__][$form->formtoken . ''] = $form;
		}

		$view = new \Stafleu\Views\Form();
		$view->std($form);
	} // main();

} // end class Form
