<?php
namespace Stafleu\Models\Forms\Fields;

class Wallet extends AbstractInput implements \Stafleu\Interfaces\FormInput {
	/**
	 * The html attributes for this form field
	 * @var array
	 */
	protected $_htmlAttributes = array(
			'type' => 'text',
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
		return true; // TODO: Write wallet validation code
	} // validate();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\FormField::getValidationError()
	 */
	public function getValidationError() {
		return '';
	} // getValidationError();

} // end class Wallet
