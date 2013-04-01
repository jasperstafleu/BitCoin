<?php
namespace Stafleu\Interfaces;

interface FormSelect extends FormField {

	/**
	 * Set an html attribute for this FormField
	 * @param string $attr			The attribute to set
	 * @param string [$val]			The value of the attribute to set. If empty (null),
	 * 													the value should equal the name of the attribute
	 * @param boolean [$ontop]	If true, put the new option first in line
	 */
	public function addOption($value, $string = null, $onTop = false);

	/**
	 * Returns the (first) selected option for this FormSelect
	 *
	 * @return		\Stafleu\Models\Forms\Fields\Option
	 */
	public function getSelectedOption();
} // end interface FormSelect