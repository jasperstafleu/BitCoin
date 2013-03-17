<?php
namespace Interfaces;

interface Form extends Model, \Serializable {
	/**
	 * Get the current step of the form
	 */
	public function getStep();

	/**
	 * Set the current step of the form
	 * @param number $step
	 */
	public function setStep($step);

	/**
	 * Set the fields of the form from the request
	 * @param unknown $request
	 */
	public function setRequest(array $request = array());

	/**
	 * Retrieve the template the view should use as based on the form's step
	 */
	public function getTemplate();

} // end interface Form