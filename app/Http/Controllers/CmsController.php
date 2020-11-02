<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Request as Request;

class CmsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Var component alert type
     * @var String
     */
    protected $_varAlertType = 'alert_type';

    /**
     * Var component alert msg
     * @var String
     */
    protected $_varAlertMsg = 'alert_message';

    /**
     * Var componet alert error
     * @var Array
     */
    protected $_alertError = ['type' => 'error', 'code' => 400];

    /**
     * Var componet alert success
     * @var Array
     */
    protected $_alertSuccess = ['type' => 'success', 'code' => 201];

    /**
     * Var componet alert warning
     * @var Array
     */
    protected $_alertWarning = ['type' => 'warning', 'code' => 206];

    /**
     * Number of itens per pages
     */
    protected $_itensPerPages = 10;

    /**
     * Layout default
     */
    protected $_keyLayout = 'layouts.app-internal';

    /**
     * Section content
     */
    protected $_keyContent = "content";

    /**
     * Return view
     *
     * @param string $name name of view
     * @param array $data array data returned
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected function showView($name, $data = [])
    {
        $this->setKeyLayout($data);
        $this->setKeyContent($data);

        $view = view($this->_path . $name, $data);

        if (Request::ajax()) {
            return $view->renderSections()[$this->_keyContent];
        }

        return $view;
    }

    /**
     * Redirect back ok status
     * @param string $msg
     *
     * @return \Illuminate\Http\Response
     */
    protected function returnBackStatusOk($msg)
    {
        return $this->redirectBack($msg, $this->_alertSuccess);
    }

    /**
     * Redirect back not ok status
     * @param string $msg
     *
     * @return \Illuminate\Http\Response
     */
    protected function returnBackStatusNotOk($msg)
    {
        return $this->redirectBack($msg, $this->_alertError);
    }

    /**
     * Redirect to the route with ok status
     * @param string $route
     * @param string $msg
     * @param Array $parameters route parameter
     *
     * @return \Illuminate\Http\Response
     */
    protected function returnRouteStatusOk($route, $msg, $parameters = [])
    {
        return $this->redirectRouteWithMsg($route, $msg, $this->_alertSuccess, $parameters);
    }

    /**
     * Redirect with ok status
     * @param string $msg
     *
     * @return \Illuminate\Http\Response
     */
    protected function returnIndexStatusOk($msg)
    {
        return $this->redirectRouteWithMsg($this->_actionIndex, $msg, $this->_alertSuccess);
    }

    /**
     * Redirect with status not ok
     * @param string $msg
     *
     * @return \Illuminate\Http\Response
     */
    protected function returnIndexStatusNotOk($msg)
    {
        return $this->redirectRouteWithMsg($this->_actionIndex, $msg, $this->_alertError);
    }

    /**
     * Redirect to router
     * @param String router name
     * @param String alert message
     * @param Array alert type
     * @param Array $parameters
     *
     * @return \Illuminate\Http\Response
     */
    private function redirectRouteWithMsg($router, $msg, array $type, $parameters = [])
    {
        if (Request::ajax()) {
            return response([$this->_varAlertMsg => $msg, $this->_varAlertType => $type['type']], $type['code']);
        }

        return redirect()
                ->action($router, $parameters)
                ->with($this->_varAlertMsg, $msg)
                ->with($this->_varAlertType, $type['type']);
    }

    /**
     * Redirect to router
     * @param String router name
     * @param Array $parameters
     *
     * @return \Illuminate\Http\Response
     */
    protected function redirectRoute($router, $parameters = [])
    {
        return redirect()
                ->route($router, $parameters);
    }

    /**
     * Redirect to router
     * @param String alert message
     * @param Array alert type ['type' => 'success', 'code' => 201]
     *
     * @return \Illuminate\Http\Response
     */
    private function redirectBack($msg, array $type)
    {
        return redirect()
                ->back()
                ->with($this->_varAlertMsg, $msg)
                ->with($this->_varAlertType, $type['type']);
    }

    /**
     * Redirect intended
     * @param  string  $default
     * @param  int  $status
     * @param  array  $headers
     * @param  bool|null  $secure
     * @return \Illuminate\Http\RedirectResponse
     */

    protected function redirectIntended($default = '/', $status = 302, $headers = [], $secure = null)
    {
        return redirect()->intended($default, $status, $headers, $secure);
    }
    /**
     * Set key layout
     *
     * @param array $data array data returned
     *
     * @return void
     */
    private function setKeyLayout(&$data = [])
    {
        $data['_keyLayout'] = $this->_keyLayout;
    }

    /**
     * Set key Content
     *
     * @param array $data array data returned
     *
     * @return void
     */
    private function setKeyContent(&$data = [])
    {
        $data['_keyContent'] = $this->_keyContent;
    }
}
