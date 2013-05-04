<?php
namespace Stafleu\Classes;

class MtGoxService implements \Stafleu\Interfaces\BitCoinService {

	/**
	 * Holder for the currently retrieved values from MtGox
	 */
	protected $_current = null;

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\BitCoinService::getCurrency()
	 */
	public function getCurrency() {
		return $this->getCurrent()->currency;
	} // getCurrency();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\BitCoinService::getDisplay()
	 */
	public function getDisplay() {
		$ret = $this->getCurrent()->display;
		if ( $this->getCurrency() === 'EUR' ) {
			$ret = implode(' ', array_reverse(explode(' ', $ret)));
		}
		return $ret;
	} // getDisplay();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\BitCoinService::getDisplayShort()
	 */
	public function getDisplayShort() {
		$ret = $this->getCurrent()->display_short;
		if ( $this->getCurrency() === 'EUR' ) {
			$ret = implode(' ', array_reverse(explode(' ', $ret)));
		}
		return $ret;
	} // getDisplayShort();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\BitCoinService::getValue()
	 */
	public function getValue() {
		return $this->getCurrent()->value;
	} // getValue();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\BitCoinService::getValueInt()
	 */
	public function getValueInt() {
		return $this->getCurrent()->value_int;
	} // getValueInt();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\BitCoinService::getIntDivider()
	 */
	public function getIntDivider() {
		$curr = $this->getCurrent();
		return round($this->getValueInt() / $this->getValue());
	} // getIntDivider();

	/**
	 * Retrieve the current values from the MtGox service, as per the $type.
	 *
	 * @param string [$type]		The type to obtain. Allows use of high, avg and low
	 * @param number [$retries]	The maximum number of times to try and call the
	 * 													webservice. If $retries != 0 and the request times
	 * 													out or fails, getCurrent will be called anew,
	 * 													otherwise, an Exception is thrown
	 * @throws \InvalidArgumentException if $type is not high, avg or low
	 * @throws \Stafleu\Models\Exception if service can't be opened or returns an
	 * 													invalid result, after $retries + 1 attempts
	 */
	public function getCurrent($type = 'high', $retries = 3) {
		if ( !in_array($type, array('high', 'avg', 'low')) ) {
			throw new \InvalidArgumentException(
					"Use of '{$type}' is not allowed, use 'high', 'avg' or 'low' instead"
			);
		}
		$comp = new \DateTime('-15 minutes');

		if ( empty($this->_current) || $this->_lastTime < $comp ) {
			$ch = curl_init('https://data.mtgox.com/api/1/BTCEUR/ticker');
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 1);
			// TODO: Get updated CA certificate bundle
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

			// fake this useragent: it speeds up MtGox API for some reason
			// TODO: Fake towards useragent string of actual useragent???
			curl_setopt(
					$ch,
					CURLOPT_USERAGENT,
					'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22'
							. ' (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.2'
			);
			if ( !($resp = curl_exec($ch)) ) {
				if ( $retries <= 0 ) {
					throw new \Stafleu\Models\Exception(curl_error($ch));
				} else {
					return $this->getCurrent($type, $retries - 1);
				}
			}
			curl_close($ch);
			$resp = str_replace('\u00a0', ' ', $resp);

			if ( !($res = json_decode($resp)) || $res->result !== 'success' ) {
				throw new \Stafleu\Models\Exception(
						'MtGox service returned invalid result'
				);
			}

			$this->_current = $res->return->$type;
			$now = floor($res->return->now / 1000000);
			$this->_lastTime = new \DateTime();
		}

		return $this->_current;
	} // _getCurrent();

	/**
	 * Magic getter
	 *
	 * @param string $what
	 */
	public function __get($what) {
		switch ( $what ) {
			case 'current' : return $this->getCurrent();
		} // switch
	} // __get();

} // MtGoxService();