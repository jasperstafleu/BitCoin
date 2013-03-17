<?php
namespace Models\Forms\Fields;

class BitCoinRate implements \Interfaces\FormField {
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
	 * Constructor
	 */
	public function __construct() {
		$this->uid = uniqid();
		$this->setAttribute('id', $this->uid);
		$this->value = (new \Events\Get)->rate();
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
		$ret = '<span';
		foreach ( $this->_htmlAttributes as $attr => $val ) {
			$ret .= ' ' . $attr . '="' . addslashes($val) . '"';
		} // foreach
		$ret .= ">" . $this->value . "</span>";
		return $ret;
	} // toHtml();

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\Model::__toString()
	 */
	public function __toString() {
		return $this->value->display;
	} // __toString();

} // end class Email