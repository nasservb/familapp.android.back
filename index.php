<?php //allahoma sale ala mohammad va ale mohammad
	// include 'ps_cdn_ev0.02.php';
	// ps_cdn_start('mamadar.ir','mamadarir');
	
	require_once ('GSMS.php');
	//-------Router system to map url to segment
	$GSMS =new GSMS(); 
	//$router = new router(); 
	 
	
	GSMS::$class['router']->_set_routing();
	
	ob_start(); // start the output buffer


	/*
 * --------------------------------------------------------------------
 * DEFAULT CONTROLLER
 * --------------------------------------------------------------------
 *
 * Normally you will set your default controller in the GSMS.php file.
 * You can, however, force a custom routing by hard-coding a
 * specific controller class/function here.  For most applications, you
 * WILL NOT set your routing here, but it's an option for those
 * special instances where you might want to override the standard
 * routing in a specific front controller that shares a common CI installation.
 *
 * IMPORTANT:  If you set the routing here, NO OTHER controller will be
 * callable. In essence, this preference limits your application to ONE
 * specific controller.  Leave the function name blank if you need
 * to call functions dynamically via the URI.
 *
 * Un-comment the $routing array below to use this feature
 *
 */
	// The directory name, relative to the "controllers" folder.  Leave blank
	// if your controller is not in a sub-folder within the "controllers" folder
	// $routing['directory'] = '';

	// The controller class file name.  Example:  Mycontroller
	// $routing['controller'] = '';

	// The controller function you wish to be called.
	// $routing['function']	= '';
	
	// Set any routing overrides that may exist in the main index file
	if (isset($routing))
	{
		GSMS::$class['router']->_set_overrides($routing);
	}//if
	/*
 * ------------------------------------------------------
 *  Security check
 * ------------------------------------------------------
 *
 *  None of the functions in the app controller or the
 *  loader class can be called via the URI, nor can
 *  controller functions that begin with an underscore
 */
	$directory = GSMS::$class['router']->fetch_directory();

	

	$class  = GSMS::$class['router']->fetch_class();
	$method = GSMS::$class['router']->fetch_method();
 
	if (file_exists(GSMS::$controllersDir.$directory .$class .'.php'))
	{
		if (!class_exists($class))
			include(GSMS::$controllersDir.$directory .$class .'.php');
	}	
	else if ( file_exists(GSMS::$pluginsDir.$directory .$class .'.php'))
	{
		if (!class_exists($class))
			include(GSMS::$pluginsDir.$directory .$class .'.php');
	}		
	else
	{		
		GSMS::$class['exceptions']->show_error('سایت دچار مشکل شده است . لطفآ در زمان دیگری تلاش کنید.');
	}
	 
	
	if ( ! class_exists($class)
		OR strncmp($method, '_', 1) == 0
		//OR in_array(strtolower($method), array_map('strtolower', get_class_methods('Controller')))
		)
	{
		
		if ( ! empty(GSMS::$class['router']->routes['404_override']))
		{
			$x = explode('/', GSMS::$class['router']->routes['404_override']);
			$class = $x[0];
			$method = (isset($x[1]) ? $x[1] : 'index');
			if ( ! class_exists($class))
			{
				if (file_exists(GSMS::$controllersDir.$class.'.php'))
				{
					if (!class_exists($class))
						include_once(GSMS::$controllersDir.$class.'.php');
				}
				else if (file_exists(GSMS::$pluginsDir.$class.'.php'))
				{
					if (!class_exists($class))
						include_once(GSMS::$pluginsDir.$class.'.php');
				}
				else 
				{	
					GSMS::$class['exceptions']->show_404("{$class}/{$method}");
					
				}//if
				
				
				
			}//if
		}
		else
		{
			GSMS::$class['exceptions']->show_404("{$class}/{$method} ");
			
		}//else
		
	}//if
	$CI = new $class();
/*
 * ------------------------------------------------------
 *  Call the requested method
 * ------------------------------------------------------
 */
	// Is there a "remap" function? If so, we call it instead
	if (method_exists($CI, '_remap'))
	{
		$CI->_remap($method, array_slice(GSMS::$class['router']->uri->rsegments, 2));
	}
	else
	{
		// is_callable() returns TRUE on some versions of PHP 5 for private and protected
		// methods, so we'll use this workaround for consistent behavior
		if ( ! in_array(strtolower($method), array_map('strtolower', get_class_methods($CI))))
		{
			// Check and see if we are using a 404 override and use it.
			if ( ! empty(GSMS::$class['router']->routes['404_override']))
			{
				$x = explode('/', GSMS::$class['router']->routes['404_override']);
				$class = $x[0];
				$method = (isset($x[1]) ? $x[1] : 'index');
				if ( ! class_exists($class))
				{
					if ( file_exists(GSMS::$controllersDir.$class.'.php'))
					{
						if (!class_exists($class))
							include_once(GSMS::$controllersDir.$class.'.php');
					}
					else if ( file_exists(GSMS::$pluginsDir.$class.'.php'))
					{
						if (!class_exists($class))
							include_once(GSMS::$pluginsDir.$class.'.php');
					}
					else 
					{
						GSMS::$class['exceptions']->show_404("{$class}/{$method}");
						
					}

					unset($CI);
					$CI = new $class();
				}//if
			}
			else
			{
				GSMS::$class['exceptions']->show_404("{$class}/{$method}");
				
			}//else
		}//if

		// Call the requested method.
		// Any URI segments present (besides the class/function) will be passed to the method for convenience
		call_user_func_array(array(&$CI, $method), array_slice(GSMS::$class['router']->uri->rsegments, 2));
	}//else

	ob_get_contents();  
	ob_end_flush(); // Send the output and turn off output buffering
	

?>
