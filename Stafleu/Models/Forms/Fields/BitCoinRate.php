<?php
namespace Stafleu\Models\Forms\Fields;

class BitCoinRate implements \Stafleu\Interfaces\FormField {
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
		$this->value = (new \Stafleu\Events\Get)->rate();
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
		$ret = '<span';
		foreach ( $this->_htmlAttributes as $attr => $val ) {
			$ret .= ' ' . $attr . '="' . addslashes($val) . '"';
		} // foreach
		$ret .= ">" . $this->value . "</span>";
		return $ret;
	} // toHtml();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\Model::__toString()
	 */
	public function __toString() {
		return $this->value->display;
	} // __toString();

} // end class BitCoinRate