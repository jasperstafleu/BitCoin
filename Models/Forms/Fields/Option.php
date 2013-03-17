<?php
namespace Models\Forms\Fields;

class Option implements \Interfaces\FormField {
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
	 * @see \Interfaces\FormField::getAttribute()
	 */
	public function getAttribute($attr) {
		return $this->_htmlAttributes[$attr] ?: null;
	} // getAttribute();

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\FormField::setAttribute()
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
	 * @see \Interfaces\FormField::toHtml()
	 */
	public function toHtml() {
		$ret = '<option';
		foreach ( $this->_htmlAttributes as $attr => $val ) {
			$ret .= ' ' . $attr . '="' . addslashes($val) . '"';
		} // foreach
		$ret .= ">" . $this->string . "</option>	";
		return $ret;
	} // toHtml();

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\Model::__toString()
	 */
	public function __toString() {
		return $this->_htmlAttributes['value'];
	} // __toString();

} // end class Email