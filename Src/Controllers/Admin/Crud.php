<?php

namespace MvcCore\Rental\Controllers\Admin;

use MvcCore\Rental\Support\Http\Request;


abstract class Crud
{

    /***
     * 
     * index function
     */
    abstract public function index();
    /***
     * 
     * create function
     */
    abstract public function create(Request $request);

    /***
     * 
     * update function
     */
    abstract public function update(Request $request);

    /***
     * 
     * destroy function
     */
    abstract protected function destroy(Request $request);

}