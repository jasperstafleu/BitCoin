<?php
namespace Stafleu\Classes;

class BitCoinWebserviceClient extends JSONRPCClient {

    /**
     * Constructor. Basically gathers and uses the default values to insert into
     * the parent's constructor
     */
    public function __construct($location = null, array $options = array()) {
        $options = array_merge(array(
                'login' => '********',
                'password' => '********',
                'exceptions' => '\Stafleu\Models\Exception',
        ), $options);

        $location = empty($location) ? 'http://127.0.0.1:8888/' : $location;

        parent::__construct($location, $options);
    } // __construct();

} // end class BitCoinWebserviceClient
?>