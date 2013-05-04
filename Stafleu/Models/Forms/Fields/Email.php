<?php
namespace Stafleu\Models\Forms\Fields;

class Email extends AbstractInput implements \Stafleu\Interfaces\FormInput
{
    /**
     * The html attributes for this form field
     * @var array
     */
    protected $_htmlAttributes = array(
            'type' => 'email',
    );

    /**
     * (non-PHPdoc)
     * @see \Stafleu\Interfaces\FormField::validate()
     */
    public function validate($value = null)
    {
        if ( $value === null ) {
            $value = $this->getAttribute('value');
        }
        if ( $value === null ) {
            return true;
        }
        return !!filter_var($value, FILTER_VALIDATE_EMAIL);
    } // validate();

    /**
     * (non-PHPdoc)
     * @see \Stafleu\Interfaces\FormField::getValidationError()
     */
    public function getValidationError()
    {
        if ( !$this->validate($this->getAttribute('value')) ) {
            return 'Not a valid email address';
        }
        return '';
    } // getValidationError();

} // end class Email