<?php
namespace Stafleu\Models\Forms\Fields;

abstract class AbstractInput implements \Stafleu\Interfaces\FormInput {
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
			'type' => 'text',
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
		$ret = '<input';
		foreach ( $this->_htmlAttributes as $attr => $val ) {
			$ret .= ' ' . $attr . '="' . htmlspecialchars($val) . '"';
		} // foreach
		$ret .= "/>";
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
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\Model::__toString()
	 */
	public function __toString() {
		return $this->_htmlAttributes['value'];
	} // __toString();

} // end class Email