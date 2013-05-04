<?php
namespace Stafleu\Interfaces;

interface Form extends Model, \Serializable
{
    /**
     * Set the fields of the form from the request
     * @param array $request
     */
    public function setRequest(array $request = array());

    /**
     * Retrieve the template the view should use as based on the form's step
     */
    public function getTemplate();

} // end interface Form