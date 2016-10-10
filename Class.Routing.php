<?php
/**
 * Class used to apply http request with the MVC structure
 * @author S. Martin
 * @link http://www.hevs.ch
 */

class Routing{

	private static $instance;

	/**
	 * prevent from direct creation of object
	 */
	private function __construct()
	{
	}

	/**
	 * singleton method
	 */
	public static function getInstance()
	{
		if (!isset(self::$instance)|| self::$instance == null)
		{
			$c = __CLASS__;
			self::$instance = new $c();
		}
		return self::$instance;
	}

	/**
	 * Redirect through controller and view
	 */
	public function route(){

		//Read URL
		$path = parse_url(
				(isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' .
				$_SERVER['HTTP_HOST'] .
				$_SERVER['REQUEST_URI']
		);

		$parts = explode("/", substr($path['path'], 1));

		//Get the controller and the view or method
		$controller = strtolower((@$parts[1]) ? $parts[1] : "home");
		$method = strtolower((@$parts[2]) ? $parts[2] : "");
        $GLOBALS['value'] = strtolower((@$parts[3]) ? $parts[3] : "");

        if (!method_exists("{$controller}Controller", "{$method}")) {
            $method = $controller;
        }

		//Check if controller and method exist
		if(!file_exists(ROOT_DIR."controllers/Class.{$controller}Controller.php")) {
			$controller = "error";
			$method = "http404";
		}
		/*elseif (isset($method)){
            $method = $controller;
		    if (!method_exists("{$controller}Controller", "{$method}")) {
                $controller = "error";
                $method = "http404";
            } else {
                $method = $controller;
            }
		}*/



		//Instantiate controller class
		$class = $controller . "Controller";
		$controller_instance = new $class($controller, $method);

		//Call controller method first then display the view
		$controller_instance->$method();
		$controller_instance->display();
	}

}