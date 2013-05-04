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
        $this->_setUID();
    } // __construct();

    /**
     * Set the UID for this form input
     */
    private function _setUID() {
        $this->uid = uniqid();
        $this->setAttribute('id', $this->uid);
    } // _setUID();

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
        return '';
    } // getValidationError();

    /**
     * (non-PHPdoc)
     * @see \Stafleu\Interfaces\Model::__toString()
     */
    public function __toString() {
        return $this->_htmlAttributes['value'];
    } // __toString();

    /**
     * (non-PHPdoc)
     * @see Serializable::serialize()
     */
    public function serialize() {
        if ( isset($this->_htmlAttributes['value']) ) {
            return serialize($this->_htmlAttributes['value']);
        }
        return     serialize(null);
    } // serialize();

    /**
     * (non-PHPdoc)
     * @see Serializable::unserialize()
     */
    public function unserialize($str) {
        $val = unserialize($str);
        if ( $val !== null ) {
            $this->_htmlAttributes['value'] = $val;
        }
        $this->_setUID();
    } // unserialize();

} // end class Email