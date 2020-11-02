<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CmsController;

class DashboardController extends CmsController
{

    /**
     * Path to views
     */
    protected $_path = 'dashboard.';

    /**
     * Action Index in controller
     */
    protected $_actionIndex = 'DashboardController@index';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showView( __FUNCTION__ );
    }
}
