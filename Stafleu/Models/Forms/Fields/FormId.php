<?php
namespace Stafleu\Models\Forms\Fields;

class FormId implements \Stafleu\Interfaces\FormInput {
	/**
	 * Unique id for this field
	 * @var string
	 */
	public $uid = '';

	/**
	 * Some random number used in the calculation of the hash to ensure CSRF
	 * safety
	 * @var number
	 */
	private $_randomId = 0;

	/**
	 * The html attributes for this form field
	 * @var array
	 */
	protected $_htmlAttributes = array(
			'type' => 'hidden',
	);

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->uid = uniqid();
		$this->_randomId = mt_rand();
		$this->_htmlAttributes['value'] = $this->_generateValue();
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
		if ( $value === null ) {
			$value = $this->getAttribute('value');
		}
		if ( $value === null ) {
			return true;
		}
		return $value === $this->_generateValue();
	} // validate();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\FormField::getValidationError()
	 */
	public function getValidationError() {
		if ( !$this->validate($this->getAttribute('value')) ) {
			return 'NO VALID TOKEN';
		}
		return '';
	} // getValidationError();

	/**
	 * Generates the value for this formtoken.
	 *
	 * @return string
	 */
	protected function _generateValue() {
		return sha1($this->_randomId . session_id() . $_SERVER['REMOTE_ADDR']);
	} // _generateValue();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\Model::__toString()
	 */
	public function __toString() {
		return $this->_htmlAttributes['value'];
	} // __toString();

} // end class FormId
