<?php
namespace Stafleu\Views;

class Form implements \Stafleu\Interfaces\View {

    /**
     * (non-PHPdoc)
     * @see \Stafleu\Interfaces\View::std()
     */
    public function std(\Stafleu\Interfaces\Model $form = null) {
        if ( $form === null ) {
            throw new \Stafleu\Models\Exception('No model passed to the view');
        }
        require $form->getTemplate();
    } // _construct();

} // end class Form