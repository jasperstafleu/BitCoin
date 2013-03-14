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
	public static function ticker(array $path = array(), array $request = array(), $enacter = 'program') {
		// no operations required

		// get BitCoinTicker as based on MtGoxService
		$service = '\\Classes\\' . CLASS_BITCOINTICKERSERVICE;
		$ticker = new \Models\BitCoinTicker(new $service);

		if ( $enacter != 'user' ) {
			return $ticker;
		}

		// show the correct view
		if ( !($viewtype = reset($path)) ) {
			$viewtype = 'std';
		}
		$view = new \Views\Ticker();
		return $view->$viewtype($ticker);
	} // ticker();

} // end class Get