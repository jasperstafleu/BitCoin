<?php
namespace Stafleu\Models\Forms\Fields;

class FormId implements \Stafleu\Interfaces\FormInput {
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
			'type' => 'hidden',
	);

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->uid = uniqid();
	} // __construct();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\FormField::getAttribute()
	 */
	public function getAttribute($attr) {
		return $this->_htmlAttributes[$attr] ?: null;
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
			$ret .= ' ' . $attr . '="' . addslashes($val) . '"';
		} // foreach
		$ret .= "/>";
		return $ret;
	} // toHtml();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\Model::__toString()
	 */
	public function __toString() {
		return $this->_htmlAttributes['value'];
	} // __toString();

} // end class FormId