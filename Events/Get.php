<?php
namespace Events;

class Get implements \Interfaces\Event {

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\Event::trigger()
	 */
	public static function trigger(array $path = array(), array $request = array(), $enacter = 'program') {
		if ( !($what = array_shift($path)) ) {
			throw new \Exception('Incomplete path length');
		}

		self::$what($path, $request, $enacter);
	} // trigger();

	/**
	 * Event for obtaining the
	 *
	 * @param array $path
	 * @param array $request
	 * @param string $enacter
	 */
	public static function rate(array $path = array(), array $request = array(), $enacter = 'program') {
		// no operations required

		// get BitCoinRate as based on MtGoxService
		$service = '\\Classes\\' . CLASS_BITCOINRATESERVICE;
		$rate = new \Models\BitCoinRate(new $service);

		if ( $enacter != 'user' ) {
			return $rate;
		}

		// show the correct view
		if ( !($viewtype = reset($path)) ) {
			$viewtype = 'std';
		}
		$view = new \Views\Rate();
		return $view->$viewtype($rate);
	} // rate();

} // end class Get