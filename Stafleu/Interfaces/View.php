<?php
namespace Stafleu\Interfaces;

interface View {

    /**
     * Default view method. Each view needs to implement this as fallback view
     * type. It can also be used as "template" for each other view type.
     *
     * @param \Stafleu\Interfaces\Model $model
     */
    public function std(\Stafleu\Interfaces\Model $model);

} // end interface view