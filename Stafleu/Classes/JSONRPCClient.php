<?php
namespace Stafleu\Classes;

class JSONRPCClient implements \Stafleu\Interfaces\RPCClient {

	/**
	 * Holder for the URI to send requests to
	 * @var string
	 */
	private $_location = '';

	/**
	 * Whether to debug
	 * @var boolean
	 */
	private $_trace = false;

	/**
	 * The version of the RPC to use
	 * @var string
	 */
	private $_version = '2.0';

	/**
	 * The username to use for basic authentication of the service
	 * @var string
	 */
	private $_login;

	/**
	 * The password to use for basic authentication of the service
	 * @var string
	 */
	private $_password;

	/**
	 * Holder for the last request
	 * @var string
	 */
	private $_lastRequest = '';

	/**
	 * Holder for the last request headers
	 * @var string
	 */
	private $_lastRequestHeaders = '';

	/**
	 * Holder for the last response
	 * @var string
	 */
	private $_lastResponse = '';

	/**
	 * Holder for the last response headers
	 * @var string
	 */
	private $_lastResponseHeaders = '';

	/**
	 * The class of the exception to throw when the service returns an exception
	 * @var string
	 */
	private $_exceptions = '\Exception';

	/**
	 * The request id of the last request. 0 indicates no requests send yet
	 * @var integer
	 */
	private static $_id = 0;

	/**
	 * Available options are:
	 * - trace:					Set this to true if you wish to trace requests using the
	 * 									__getLastRequest, __getLastRequestHeaders,
	 * 									__getLastResponse and __getLastResponseHeaders methods
	 * - location:			If no location is given, place it in here
	 * - version:				The RPC version to use. Defaults to 2.0
	 * - login:					The username for the requests made
	 * - password:			The password for the requests made
	 * - exceptions			The class of the exception to throw when the service
	 * 									returns an error. Defaults to \Exception
	 *
	 * TODO
	 * Something with SSL
	 * - local_cert			Local SSL certification
	 * - passphrase 		Local certificate passphrase
	 *
	 *
	 * @see \Stafleu\Interfaces\RPCClient::__construct()
	 */
	public function __construct($location, array $options = array()) {
		if ( empty($location) ) {
			$location = $options['location'];
		}

		if ( isset($options['trace']) ) {
			$this->_trace = !!$options['trace'];
		}
		if ( isset($options['version']) ) {
			$this->_version = $options['version'];
		}
		if ( isset($options['login']) ) {
			$this->_login = $options['login'];
		}
		if ( isset($options['password']) ) {
			$this->_password = $options['password'];
		}
		if ( isset($options['exceptions']) ) {
			$this->_exceptions = $options['exceptions'];
		}

		$this->__setLocation($location);
	} // __construct();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\RPCClient::__call()
	 */
	public function __call($function_name, $arguments) {
		return $this->__doRequest(json_encode($arguments), $this->_location, $function_name, $this->_version);
	} // __call();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\RPCClient::__doRequest()
	 */
	public function __doRequest($request, $location, $action, $version = false, $one_way = false) {
		// prepares request
		$request = array(
				'method'	=> $action,
				'params'	=> json_decode($request),
				'id'			=> ++self::$_id,
		);
		if ( version_compare($this->_version, '1.1') < 0 ) {
			// no version given for versions lower than 1.1
		} else if ( version_compare($this->_version, '2.0') < 0 ) {
			// before version 2.0, version was sent using the version key
			$request['version'] = $this->_version;
		} else {
			// version 2.0 changed the version key to jsonrpc
			$request['jsonrpc'] = $this->_version;
		}

		$request = json_encode($request);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $location);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',				// send request as JSON
			'Content-length: ' . strlen($request)		// send content length
		));

		if ( !empty($this->_login) && !empty($this->_password) ) {
			curl_setopt($curl, CURLOPT_USERPWD, $this->_login . ':' . $this->_password);
		}

		if ( $this->_trace ) {
			curl_setopt($curl, CURLOPT_HEADER, true);
			curl_setopt($curl, CURLINFO_HEADER_OUT, true);
		}

		if ( parse_url($this->_location, PHP_URL_SCHEME) === 'https' ) {
			curl_setopt($curl, CURLOPT_SSLVERSION, 3);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
		}

		$response = curl_exec($curl);

		if ( !empty($this->_trace) ) {
			// trace is on: set some usefull
			$this->_lastRequest = $request;
			$headerSep = "\r\n\r\n";
			$tmp = explode($headerSep, $response);
			$this->_lastResponseHeaders = array_shift($tmp);
			$this->_lastResponse = $response = implode($headerSep, $tmp);
			$this->_lastRequestHeaders = curl_getinfo($curl, CURLINFO_HEADER_OUT);
			if ( strpos($this->_lastRequestHeaders, $headerSep) === strlen($this->_lastRequestHeaders) - strlen($headerSep) ) {
				$this->_lastRequestHeaders = substr($this->_lastRequestHeaders, 0, -strlen($headerSep));
			}
		}

		// if something went wrong throw the appropriate error
		if ( !$result = json_decode($response) ) {
			if ( $error = curl_error($curl) ) {
				throw new $this->_exceptions($error);
			}
			throw new $this->_exceptions('No valid response received');
		}
		if ( !empty($result->error) ) {
			throw new $this->_exceptions($result->error->message);
		}
		if ( !isset($result->result) ) {
			throw new $this->_exceptions('No valid result received');
		}

		return $result->result;
	} // __doRequest();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\RPCClient::__getFunctions()
	 */
	public function __getFunctions() {
		return explode("\n", $this->help());
	} // __getFunctions();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\RPCClient::__getLastRequest()
	 */
	public function __getLastRequest() {
		return $this->_lastRequest;
	} // __getLastRequest();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\RPCClient::__getLastRequestHeaders()
	 */
	public function __getLastRequestHeaders() {
		return $this->_lastRequestHeaders;
	} // __getLastRequestHeaders();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\RPCClient::__getLastResponse()
	 */
	public function __getLastResponse() {
		return $this->_lastResponse;
	} // __getLastResponse();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\RPCClient::__getLastResponseHeaders()
	 */
	public function __getLastResponseHeaders() {
		return $this->_lastResponseHeaders;
	} // __getLastResponseHeaders();

	/**
	 * Currently lacks implementation; therefore: Throws exception
	 *
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\RPCClient::__setCookie()
	 */
	public function __setCookie($name, $value = false) {
		throw \Exception(__METHOD__ . ' lacks implementation');
	} // __setCookie();

	/**
	 * (non-PHPdoc)
	 * @see \Stafleu\Interfaces\RPCClient::__setLocation()
	 */
	public function __setLocation($location) {
		$prev = $this->_location;
		$this->_location = $location;
		return $prev;
	} // __setLocation();

} // end class JSONRPCClient
?>