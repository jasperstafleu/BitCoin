<?php
namespace Stafleu\Models\Forms\Fields;

class BitCoinRate
		extends AbstractInput
		implements \Stafleu\Interfaces\FormField {
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->value = (new \Stafleu\Events\Get)->rate();
	} // __construct();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\FormField::validate()
	 */
	public function validate($value = null) {
		if ( $value === null ) {
			$value = $this->getAttribute('value');
		}
		if ( $value === null ) {
			return true;
		}
		return filter_var($value, FILTER_VALIDATE_FLOAT);
	} // validate();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\FormField::getValidationError()
	 */
	public function getValidationError() {

	} // getValidationError();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\Model::__toString()
	 */
	public function __toString() {
		return $this->value->display;
	} // __toString();

	/**
	 * (non-PHPdoc)
	 * @see Serializable::serialize()
	 */
	public function serialize() {
		return serialize($this->value);
	} // serialize();

	/**
	 * (non-PHPdoc)
	 * @see Serializable::unserialize()
	 */
	public function unserialize($str) {
		$this->value = unserialize($str);
	} // unserialize();

} // end class BitCoinRate