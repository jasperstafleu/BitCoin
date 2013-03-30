<?php
namespace Stafleu\Models;

class BitCoinRate implements \Stafleu\Interfaces\Model {

	/**
	 * The bitcoin value in currency units
	 * @var number
	 */
	public $value = PHP_INT_MAX;

	/**
	 * An integer value for the value. Use intDivider
	 * @var number
	 */
	public $valueInt = PHP_INT_MAX;

	/**
	 * Factor between the int and float value
	 * @var number
	 */
	public $intDivider = 1;

	/**
	 * String representation of the value.
	 * @var string
	 */
	public $display = '';

	/**
	 * Shorter version of display
	 * @var string
	 */
	public $displayShort = '';

	/**
	 * The currency denotifier of the value
	 * @var string
	 */
	public $currency = '';

	/**
	 * Constructor
	 *
	 * @param \Stafleu\Interfaces\BitCoinService $service
	 */
	public function __construct(\Stafleu\Interfaces\BitCoinService $service) {
		$this->value = (float) $service->getValue();
		$this->valueInt = (int) $service->getValueInt();
		$this->intDivider = (int) $service->getIntDivider();
		$this->display = $service->getDisplay();
		$this->displayShort = $service->getDisplayShort();
		$this->currency = $service->getCurrency();
	} // __construct();

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\Model::__toString()
	 */
	public function __toString() {
		return $this->display;
	} // __toString();

} // end class BitCoinRate