<?php
namespace Stafleu\Interfaces;

/**
 * The RPCClient interface is based upon PHP's SoapClient class. It requires
 * exactly those methods.
 *
 * @author Jasper Stafleu
 */
interface RPCClient {

	/**
	 * Constructor
	 *
	 * @param string	$location	The location to send requests for this client to
	 * @param array		[$options]	Optional options. Differ per implementation
	 */
	public function __construct($location, array $options = array());

	/**
	 * Magic caller. Used to call the RPC's methods
	 *
	 * @param string $function_name
	 * @param mixed $arguments
	 * @return mixed
	 */
	public function __call($function_name, $arguments);

	/**
	 * Does a request called $request, to RPC $location,
	 * @param string	$request	The request body
	 * @param string	$location	The URI to send the request to
	 * @param string	$action		The action to undertake. For SOAP, this is
	 * 								the HTTP word
	 * @param string	$version	The version of the request type. Defaults to
	 * 								false, since not all clients need to
	 * 								implement it
	 * @param boolean	$one_way	If true, will not wait for the request to
	 * 								return. Use this for calling methods when
	 * 								the response does not matter. Not guaranteed
	 * 								to be implemented
	 * @return mixed
	 */
	public function __doRequest($request, $location, $action, $version = false,
			$one_way = false);

	/**
	 * Returns a listing of valid functions to call.
	 *
	 * @return array
	 */
	public function __getFunctions();

	/**
	 * Returns the last request made. In some cases (such as php's SoapClient),
	 * this might return nothing if debug state is false.
	 *
	 * @return string
	 */
	public function __getLastRequest();

	/**
	 * Returns the header sent when the last request was made. In some cases
	 * (such as php's SoapClient), this might return nothing if debug state is
	 * false.
	 *
	 * @return string
	 */
	public function __getLastRequestHeaders();

	/**
	 * Returns the last response given. In some cases (such as php's SoapClient),
	 * this might return nothing if debug state is false.
	 *
	 * @return string
	 */
	public function __getLastResponse();

	/**
	 * Returns the header sent when the last request was made. In some cases
	 * (such as php's SoapClient), this might return nothing if debug state is
	 * false.
	 *
	 * @return string
	 */
	public function __getLastResponseHeaders();

	/**
	 * Defines a cookie to be sent along with the RPC requests.
	 *
	 * @param string $name
	 * @param string [$value]	If not supplied, the cookie will be removed
	 */
	public function __setCookie($name, $value = false);

	/**
	 * Sets the location of the Web service to use
	 *
	 * @param string $location
	 * @return string	The old location
	 */
	public function __setLocation ($location);

} // interface RPCClient



















