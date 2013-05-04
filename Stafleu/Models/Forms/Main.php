<?php
namespace Stafleu\Models\Forms;

class Main implements \Stafleu\Interfaces\Form
{
    /**
     * The fields relevant to this form
     * @var unknown
     */
    protected $_fields = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_setFieldVars();
    } // __construct();

    /**
     * Sets the fields variable. It contains information such as field
     * requiredness, validation state and type.
     */
    protected function _setFieldVars()
    {
        $this->_fields = array(
            'formtoken'         => new Fields\FormId,
            'step'              => new Fields\Step,
            'wallet'            => new Fields\Wallet,
            'wallet_remember'   => new Fields\Checkbox,
            'number'            => new Fields\Number,
            'rate'              => new Fields\BitCoinRate,
            'amount'            => new Fields\TotalPurchaseAmount,
            'email'             => new Fields\Email,
            'bank'              => new Fields\IdealBank,
        );

        $this->_setSteps();
        $this->_setNames();
    } // _setFieldVars

    /**
     * Sets the steps field.
     */
    private function _setSteps()
    {
        $this->_fields['step']
            ->addStep('start')
            ->addStep('step2')
            ->setAttribute('value', 'start')
        ;
    } // _setSteps();

    /**
     * Sets the names of the fields
     */
    private function _setNames()
    {
        foreach ( $this->_fields as $name => $field ) {
            $field->setAttribute('name', $name)
            //        ->setAttribute('required')
            ;
        } // foreach
    } // _setNames();

    /**
     * (non-PHPdoc)
     * @see \Stafleu\Interfaces\Form::setRequest()
     */
    public function setRequest(array $request = array())
    {
        foreach ( $this->_fields as $name => $field ) {
            if ( isset($request[$name]) ) {
                $field->setAttribute('value', $request[$name]);
            }
            if ( $field instanceof \Stafleu\Interfaces\CalculationFormField ) {
                $field->calculate($this);
            }
        } // foreach
    } // setRequest();

    /**
     * (non-PHPdoc)
     * @see \Stafleu\Interfaces\Form::getTemplate()
     */
    public function getTemplate()
    {
        return BASEDIR . 'templates/main_form_step_' . $this->step . '.phtml';
    } // getTemplate();

    /**
     * Validates the request for this form
     *
     * @param array $req
     */
    public function validate(array $req = array())
    {
        foreach ( $req as $key => $val ) {
            if ( !$this->_fields[$key]->validate($val) ) {
                return false;
            }
        } // foreach
        return true;
    } // validate();

    /**
     * (non-PHPdoc)
     * @see Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
                'fields' => $this->_fields,
        ));
    } // serialize();

    /**
     * (non-PHPdoc)
     * @see Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        $tmp = unserialize($serialized);
        $this->_fields = $tmp['fields'];
        $this->_setSteps();
        $this->_setNames();
    } // unserialize();

    /**
     * Magic getter. Retrieves values of fields from this form
     * @param string $field
     * @return \Stafleu\Models\Forms\FormField
     */
    public function __get($field)
    {
        return $this->_fields[$field];
    } // __get();

    /**
     * (non-PHPdoc)
     * @see \Stafleu\Interfaces\Model::__toString()
     */
    public function __toString()
    {
        return print_r($this->_values, true);
    } // _toString();

} // end class Main
