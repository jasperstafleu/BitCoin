<?php
namespace Stafleu\Interfaces;

interface BitCoinService {

    /**
     * Returns the (float) value for the most recent call to this service
     */
    public function getValue();

    /**
     * Returns the integer value for the most recent call to this service
     */
    public function getValueInt();

    /**
     * Returns the factor by which the integer value and float value differ. This
     * is usually in multiples of 10
     */
    public function getIntDivider();

    /**
     * Returns a displayable version of the value of the most recent call to this
     * service
     */
    public function getDisplay();

    /**
     * Returns a shorter displayable version of the value of the most recent call
     * to this service
     */
    public function getDisplayShort();

    /**
     * Returns the currency for this service
     */
    public function getCurrency();

} // end interface BitCoinService