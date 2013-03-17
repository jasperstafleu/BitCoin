<?php
namespace Models\Forms;

class Main implements \Interfaces\Form	 {
	/**
	 * The current step of this form
	 * @var number
	 */
	protected $_step = 1;

	/**
	 * The fields relevant to this form
	 * @var unknown
	 */
	protected $_fields = array();

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->_setFieldVars();
	} // __construct();

	/**
	 * Sets the fields variable. It contains information such as field
	 * requiredness, validation state and type.
	 */
	protected function _setFieldVars() {
		$this->_fields = array(
			'id'			=> new Fields\FormId,
			'wallet'	=> new Fields\Wallet,
			'number'	=> new Fields\Number,
			'rate'		=> new Fields\BitCoinRate,
			'email'		=> new Fields\Email,
			'bank'		=> new Fields\IdealBank,
		);

		foreach ( $this->_fields as $name => $field ) {
			$field->setAttribute('name', $name)
				//		->setAttribute('required')
			;
		} // foreach
	} // _setFieldVars

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\Form::getStep()
	 */
	public function getStep() {
		return $this->_step;
	} // getStep();

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\Form::setStep()
	 */
	public function setStep($step) {
		$this->_step = $step;
		return $this;
	} // setStep();

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\Form::setRequest()
	 */
	public function setRequest(array $request = array()) {
		foreach ( $this->_fields as $name => $field ) {
			if ( isset($request[$name]) ) {
				$field->setAttribute('value', $request[$name]);
			}
		} // foreach

	} // setRequest();

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\Form::getTemplate()
	 */
	public function getTemplate() {
		return BASEDIR . 'templates/main_form_step' . $this->_step . '.phtml';
	} // getTemplate();

	/**
	 * (non-PHPdoc)
	 * @see Serializable::serialize()
	 */
	public function serialize() {

	} // serialize();

	/**
	 * (non-PHPdoc)
	 * @see Serializable::unserialize()
	 */
	public function unserialize($serialized) {

	} // unserialize();

	/**
	 * Magic getter. Retrieves values of fields from this form
	 * @param string $field
	 * @return \Models\Forms\FormField
	 */
	public function __get($field) {
		return $this->_fields[$field];
	} // __get();

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\Model::__toString()
	 */
	public function __toString() {
		return print_r($this->_values, true);
	} // _toString();



} // end class Main