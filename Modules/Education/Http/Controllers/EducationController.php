<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\CmsController;
use Illuminate\Http\Request;

class EducationController extends CmsController
{
    /**
     * Path to views
     */
    protected $_path = 'education::';

    /**
     * Action Index in controller
     */
    protected $_actionIndex = '\Modules\Education\Http\Controllers\EducationController@index';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        return $this->showView(__FUNCTION__);
    }

}
