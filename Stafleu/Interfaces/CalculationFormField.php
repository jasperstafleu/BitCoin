<?php
namespace Stafleu\Interfaces;

interface CalculationFormField
{
    /**
     * Calculate the value of this field for the passed form (which SHOULD be
     * the form containing this field).
     *
     * @param \Stafleu\Interfaces\Form $form
     * @return \Stafleu\Interfaces\CalculationFormField
     */
    public function calculate(\Stafleu\Interfaces\Form $form);

}  // CalculationFormField