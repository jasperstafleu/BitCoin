<?php
namespace Stafleu\Models\Forms\Fields;

class Option implements \Stafleu\Interfaces\FormField {
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
	 * The displayable string of the option
	 *
	 * @var string
	 */
	protected $_string = '';

	/**
	 * Constructor
	 */
	public function __construct($value, $string = null) {
		$this->uid = uniqid();
		$this->setAttribute('value', $value);
		$this->string = $string === null ? $value : $string;
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
		$ret = '<option';
		foreach ( $this->_htmlAttributes as $attr => $val ) {
			$ret .= ' ' . $attr . '="' . htmlspecialchars($val) . '"';
		} // foreach
		$ret .= ">" . $this->string . "</option>	";
		return $ret;
	} // toHtml();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\FormField::validate()
	 */
	public function validate($value = null) {
		return true;
	} // validate();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\FormField::getValidationError()
	 */
	public function getValidationError() {

	} // getValidationError();

	/**
	 * Returns whether this option is a selected option
	 *
	 * @return boolean
	 */
	public function isSelected() {
		return isset($this->_htmlAttributes['selected']);
	} // isSelected();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\Model::__toString()
	 */
	public function __toString() {
		return $this->_htmlAttributes['value'];
	} // __toString();

} // end class Option