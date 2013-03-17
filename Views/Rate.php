<?php
namespace Views;

class Rate implements \Interfaces\View {

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\View::std()
	 */
	public function std(\Interfaces\Model $model) {
		echo $model;
	} // json();

	/**
	 * Outputs the $model as a json string. Also sets the content type
	 *
	 * @param \Interfaces\Model $model
	 */
	public function json(\Interfaces\Model $model) {
		header('Content-type: application/json');
		echo json_encode($model);
	} // json();


	/**
	 * If $_REQUEST['callback'] is set, returns the $model wrapped in a javascript
	 * function (callback). Otherwise, this is an alias of json
	 *
	 * @param \Interfaces\Model $model
	 */
	public function jsonp(\Interfaces\Model $model) {
		if ( empty($_REQUEST['callback']) ) {
			$this->json($model);
			return;
		}
		header('Content-type: application/javascript');
		echo $_REQUEST['callback'] . '(' . json_encode($model) . ');';
	} // jsonp();

} // end class Rate