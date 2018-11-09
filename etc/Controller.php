<?php
require_once 'Request.php';
require_once 'View.php';

namespace Framework;

abstract class Controller
{
    // Action to be carried out
    private $action;

   // Incoming request
    protected $request;

    // Sets the incoming request
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    //Execute the action to perform.
    //Calls the method with the same name as the action on the current Controller object
    //@throws Exception If the action does not exist in the current Controller class
    public function executeAction($action)
    {
        if (method_exists($this, $action)) {
            $this->action = $action;
            $this->{$this->action}();
        }
        else {
            $classController = get_class($this);
            throw new Exception("Action '$action' non définie dans la classe $classController");
        }
    }

    // Abstract method corresponding to the default action
    // Require derived classes to implement this default action
    public abstract function index();

    // Generate the view associated with the current controller
    // @param array $ dataView Data needed for view generation
    protected function generateView($dataView = array())
    {
        // Determining the name of the view file from the name of the current controller
        $classController = get_class($this);
        $controller = str_replace("Controller", "", $classController);

        // Instantiation and generation of the viewF
       $view = new View($this->action, $controller);
        $view>generer($dataView);
    }
}