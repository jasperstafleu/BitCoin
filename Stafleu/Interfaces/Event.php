<?php
namespace Stafleu\Interfaces;

interface Event {

	/**
	 * Trigger this event. The arguments determine what actually needs to happen
	 *
	 * @param array $path			The remainder of the path
	 * @param array $request	The request ($_GET and $_REQUEST)
	 * @param string $enacter	Who triggered this event. By default, this is the
	 * 												program. Ideally, this parameter will be used to
	 * 												prevent the program from accessing certain
	 * 												operations. Therefore, never set this parameter,
	 * 												except during original Dispatch
	 */
	public static function trigger(array $path = array(),
			array $request = array(), $enacter = 'program');

} // end interface Event