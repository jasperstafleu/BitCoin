<?php
namespace Views;

class Form implements \Interfaces\View {

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\View::std()
	 */
	public function std(\Interfaces\Model $model = null) {
		require BASEDIR . 'templates/form.phtml';
	} // _construct();

} // end class Form