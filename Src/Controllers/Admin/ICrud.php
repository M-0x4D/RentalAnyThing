<?php

namespace MvcCore\Rental\Controllers\Admin;

use MvcCore\Rental\Support\Http\Request;


interface ICrud
{

    /***
     * 
     * index function
     */
    public function index();
    /***
     * 
     * create function
     */
    public function create(Request $request);

    /***
     * 
     * update function
     */
    public function update(Request $request);

    /***
     * 
     * destroy function
     */
    public function destroy(Request $request);

}