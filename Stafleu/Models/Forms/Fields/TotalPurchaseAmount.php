<?php
namespace Stafleu\Models\Forms\Fields;

class TotalPurchaseAmount extends AbstractInput implements
            \Stafleu\Interfaces\FormField
        , \Stafleu\Interfaces\CalculationFormField
{
    /**
     * The html attributes for this form field
     * @var array
     */
    protected $_htmlAttributes = array(
            'type' => 'number',
    );

    /**
     * (non-PHPdoc)
     * @see \Stafleu\Interfaces\CalculationFormField::calculate()
     */
    public function calculate(\Stafleu\Interfaces\Form $form)
    {
        $rate = $form->rate->value;
        $val = $form->number->getAttribute('value') * $rate->valueInt;
        $val /= $rate->intDivider;

        $val = max(round($val, 2), 0.01);
        $this->value = substr($rate->display, 0, strpos($rate->display, ' '))
                            . sprintf(' %01.2f', $val);
        return $this;
    } // calculate();

    /**
     * (non-PHPdoc)
     * @see \Stafleu\Models\Forms\Fields\AbstractInput::__toString()
     */
    public function __toString()
    {
        return $this->value;
    } // __toString();

} // end class TotalPurchaseAmount
