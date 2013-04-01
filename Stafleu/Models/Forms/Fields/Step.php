<?php
namespace Stafleu\Models\Forms\Fields;

class Step implements \Stafleu\Interfaces\FormInput {
	/**
	 * Unique id for this field
	 * @var string
	 */
	public $uid = '';

	/**
	 * Holder for the valid steps
	 * @var array
	 */
	protected $_steps = array();

	/**
	 * The html attributes for this form field
	 * @var array
	 */
	protected $_htmlAttributes = array(
			'type' => 'submit',
	);

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->uid = uniqid();
		$this->setAttribute('id', $this->uid);
	} // __construct();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\FormField::getAttribute()
	 */
	public function getAttribute($attr) {
		return isset($this->_htmlAttributes[$attr])
						? $this->_htmlAttributes[$attr]
						: null;
	} // getAttribute();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\FormField::setAttribute()
	 */
	public function setAttribute($attr, $val = null) {
		if ( $val === null ) {
			$val = $attr;
		}
		$this->_htmlAttributes[$attr] = $val;
		return $this;
	} // setAttribute();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\FormField::toHtml()
	 */
	public function toHtml() {
		$ret = '<button';

		foreach ( $this->_htmlAttributes as $attr => $val ) {
			if ( $attr === 'text' ) continue;
			$ret .= ' ' . $attr . '="' . htmlspecialchars($val) . '"';
		} // foreach

		$ret .= ">" . $this->getAttribute('text') . "</button>";
		return $ret;
	} // toHtml();

	/**
	 * Adds a valid step
	 *
	 * @param string $name
	 */
	public function addStep($name) {
		$this->_steps []= $name;
		return $this;
	} // addOption();

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
		return in_array($value, $this->_steps);
	} // validate();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\FormField::getValidationError()
	 */
	public function getValidationError() {
		if ( !$this->validate($this->getAttribute('value')) ) {
			return 'Value is not a valid email address';
		}
		return '';
	} // getValidationError();

	/**
	 * Returns a new Step, with as its value the one the next step would have.
	 *
	 * @return Stafleu\Models\Forms\Fields\Step
	 */
	public function getNextStep() {
		$index = array_search($this->getAttribute('value'), $this->_steps) + 1;
		if ( $index >= count($this->_steps) ) {
			return null;
		}
		$option = clone $this;
		$option->setAttribute('value',$this->_steps[$index]);
		return $option;
	} // getNextStep();

	/**
	 * Returns a new Step, with as its value the one the previous step would have.
	 *
	 * @return Stafleu\Models\Forms\Fields\Step
	 */
	public function getPreviousStep() {
		$index = array_search($this->getAttribute('value'), $this->_steps) - 1;
		if ( $index < 0 ) {
			return null;
		}
		$option = clone $this;
		$option->setAttribute('value',$this->_steps[$index]);
		return $option;
	} // getPreviousStep();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\Model::__toString()
	 */
	public function __toString() {
		return (string) $this->getAttribute('value');
	} // __toString();

} // end class Step