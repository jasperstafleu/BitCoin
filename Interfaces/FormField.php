<?php
namespace Interfaces;

interface FormField extends Model {

	/**
	 * Returns the html attribute's value as described by $attr
	 * .
	 * @param string $attr
	 * @return string || NULL
	 */
	public function getAttribute($attr);

	/**
	 * Set an html attribute for this FormField
	 * @param string $attr	The attribute to set
	 * @param string [$val]	The value of the attribute to set. If empty (null),
	 * 											the value should equal the name of the attribute
	 */
	public function setAttribute($attr, $val = null);

	/**
	 * Returns the generated html for this form field.
	 */
	public function toHtml();
} // end interface FormField