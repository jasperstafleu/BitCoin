<?php
namespace Classes;

class MtGoxService implements \Interfaces\BitCoinService {

	/**
	 * Holder for the currently retrieved values from MtGox
	 */
	protected $_current = null;

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\BitCoinService::getCurrency()
	 */
	public function getCurrency() {
		return $this->getCurrent()->currency;
	} // getCurrency();

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\BitCoinService::getDisplay()
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
	 * @see \Interfaces\BitCoinService::getDisplayShort()
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
	 * @see \Interfaces\BitCoinService::getValue()
	 */
	public function getValue() {
		return $this->getCurrent()->value;
	} // getValue();

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\BitCoinService::getValueInt()
	 */
	public function getValueInt() {
		return $this->getCurrent()->value_int;
	} // getValueInt();

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\BitCoinService::getIntDivider()
	 */
	public function getIntDivider() {
		$curr = $this->getCurrent();
		return round($this->getValueInt() / $this->getValue());
	} // getIntDivider();s

	/**
	 * Retrieve the current values from the MtGox service, as per the $type.
	 *
	 * @param string [$type]		The type to obtain. Allows use of high, avg and low
	 * @throws \InvalidArgumentException if $type is not high, avg or low
	 * @throws \Exception				if service can't be opened or returns an invalid result
	 */
	public function getCurrent($type = 'high') {
		if ( !in_array($type, array('high', 'avg', 'low')) ) {
			throw new \InvalidArgumentException("Use of '{$type}' is not allowed, use 'high', 'avg' or 'low' instead");
		}
		$comp = new \DateTime('-15 minutes');

		if ( empty($this->_current) || $this->_lastTime < $comp ) {
			$resp = '';

			if ( !($fp = fopen('https://data.mtgox.com/api/1/BTCEUR/ticker', 'r')) ) {
				throw new \Exception('Failed to open MtGox service');
			}
			while ( !feof($fp) ) {
				$resp .= str_replace('\u00a0', ' ', fgets($fp));
			} // while
			fclose($fp);

			if ( !($res = json_decode($resp)) || $res->result !== 'success' ) {
				throw new \Exception('MtGox service returned invalid result');
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