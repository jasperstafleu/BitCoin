<?php
namespace Stafleu\Models\Forms\Fields;

class Checkbox Extends AbstractInput implements \Stafleu\Interfaces\FormInput {
    /**
     * The html attributes for this form field
     * @var array
     */
    protected $_htmlAttributes = array(
            'type' => 'checkbox',
            'value' => 1,
    );

    /**
     * (non-PHPdoc)
     * @see \Stafleu\Interfaces\FormField::setAttribute()
     */
    public function setAttribute($attr, $val = null) {
        if ( $attr === 'value' ) {
            if ( !empty($val) ) {
                $this->_htmlAttributes['checked'] = 'checked';
            } else {
                unset($this->_htmlAttributes['checked']);
            }
            return $this;
        }

        return parent::setAttribute($attr, $val);
    } // setAttribute();

    /**
     * (non-PHPdoc)
     * @see \Stafleu\Interfaces\FormField::toHtml()
     */
    public function toHtml() {
        $name = $this->getAttribute('name');
        $ret = '<input type="hidden" value="0"';
        $ret .= ' name="' . htmlspecialchars($name) . '"';
        $ret .= "/>";

        return $ret . parent::toHtml();
    } // toHtml();

    /**
     * (non-PHPdoc)
     * @see \Stafleu\Interfaces\FormField::validate()
     */
    public function validate($value = null) {
        if ( $value === null ) {
            $value = $this->getAttribute('value');
        }
        return in_array($value, array(0, 1));
    } // validate();

    /**
     * (non-PHPdoc)
     * @see \Stafleu\Interfaces\FormField::getValidationError()
     */
    public function getValidationError() {
        if ( !$this->validate($this->getAttribute('value')) ) {
            return 'Not a valid email value';
        }
        return '';
    } // getValidationError();

    /**
     * (non-PHPdoc)
     * @see \Stafleu\Interfaces\Model::__toString()
     */
    public function __toString() {
        return empty($this->_htmlAttributes['value']) ? 'No' : 'Yes';
    } // __toString();

} // end class Checkbox