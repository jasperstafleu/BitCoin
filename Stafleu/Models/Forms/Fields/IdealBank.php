<?php
namespace Stafleu\Models\Forms\Fields;

class IdealBank implements \Stafleu\Interfaces\FormSelect {
	/**
	 * Unique id for this field
	 * @var string
	 */
	public $uid = '';

	/**
	 * The html attributes for this form field
	 * @var array
	 */
	protected $_htmlAttributes = array(
	);

	/**
	 * An array containing the options for this select
	 * @var array
	 */
	protected $_options = array();

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->uid = uniqid();
		$this->setAttribute('id', $this->uid);
		$this->addOption('ING');
		$this->addOption('ABN AMRO');
	} // __construct();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\FormSelect::addOption()
	 */
	public function addOption($value, $string = null, $onTop = false) {
		$option = new Option($value, $string);
		if ( $onTop ) {
			array_unshift($this->_options, $option);
		} else {
			$this->_options []= $option;
		}
		return $this;
	} // addOption();

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
		if ( $attr === 'placeholder' ) {
			if ( !empty($this->_options[0]) ) {
				$tmp = $this->_options[0]->getAttribute('value');
				if ( empty($tmp) ) {
					array_shift($this->_options);
				}
			}
			$this->addOption('', $val, true);
			$this->_options[0]->setAttribute('disabled');
			if ( $this->getSelectedOption() === null ) {
				$this->_options[0]->setAttribute('selected');
			}
		} else {
			if ( $val === null ) {
				$val = $attr;
			}
			$this->_htmlAttributes[$attr] = $val;
		}
		return $this;
	} // setAttribute();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\FormField::toHtml()
	 */
	public function toHtml() {
		$ret = '<select';
		foreach ( $this->_htmlAttributes as $attr => $val ) {
			$ret .= ' ' . $attr . '="' . htmlspecialchars($val) . '"';
		} // foreach
		$ret .= ">";

		foreach ( $this->_options as $option ) {
			if ( $this->getAttribute('value') === $option->getAttribute('value') ) {
				$option->setAttribute('selected');
			}
			$ret .= $option->toHtml();
		} // foreach

		$ret .= "</select>";

		return $ret;
	} // toHtml();

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
		return true; // TODO: write bank validation code
	} // validate();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\FormField::getValidationError()
	 */
	public function getValidationError() {
		return $this->validate() ? '' : 'No valid option selected';
	} // getValidationError();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\FormSelect::getSelectedOption()
	 */
	public function getSelectedOption() {
		foreach ( $this->_options as $option ) {
			if ( $option->isSelected() ) {
				return $option;
			}
		} // foreach
		return null;
	} // getSelectedOption();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\Model::__toString()
	 */
	public function __toString() {
		return $this->_htmlAttributes['value'];
	} // __toString();

} // end class IdealBank