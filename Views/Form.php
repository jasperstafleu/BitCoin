<?php
namespace Views;

class Form implements \Interfaces\View {

	/**
	 * (non-PHPdoc)
	 * @see \Interfaces\View::std()
	 */
	public function std(\Interfaces\Model $form = null) {
		if ( $form === null ) {
			throw new \Exception('No model passed to the view');
		}
		require $form->getTemplate();
	} // _construct();

} // end class Form