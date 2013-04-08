<?php
namespace Stafleu\Models\Forms\Fields;

class Number extends AbstractInput implements \Stafleu\Interfaces\FormInput {
	/**
	 * The html attributes for this form field
	 * @var array
	 */
	protected $_htmlAttributes = array(
			'type' => 'number',
	);

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
		return filter_var($value, FILTER_VALIDATE_FLOAT);
	} // validate();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\FormField::getValidationError()
	 */
	public function getValidationError() {
		if ( !$this->validate($this->getAttribute('value')) ) {
			return 'Value is not a valid float';
		}
		return '';
	} // getValidationError();

} // end class Number