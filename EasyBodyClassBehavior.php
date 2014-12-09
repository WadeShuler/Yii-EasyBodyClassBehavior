<?php
/**
 * Author: Wade Shuler
 */

Class EasyBodyClassBehavior extends CBehavior
{

	/**
	 * @var Array _classes
	 */
	public $_classes = array();

	/**
	 * Removes duplicate classes from the _classes array
	 * Useful so you don't have duplicate classes in your body tag
	 */
	protected function _cleanClasses() {
		$this->_classes = array_unique( $this->_classes );
	}

	/**
	 * Reset the body class (@var Array _classes) to an empty array
	 */
	public function resetBodyClass()
	{
		$this->_classes = array();
	}

	/**
	 * Sets the body class to a pre-defined array of classes
	 * @var Array class An array of the classes to set
	 * @var Boolean override (optional default=true) If you want to override or merge the arrays
	 */
	public function setBodyClass($class, $override=true)
	{
		if ( $override === true ) {
			$this->resetBodyClass();
		}

		if ( is_array($class) ) {
			if ($override === true) {
				$this->resetBodyClass();
				$this->_classes = $class;
			} else {
				array_merge($this->_classes, $class);
			}
		} else {
			// if only a string passed, convert it to array
			$this->_classes = array($class);
		}
	}

	/**
	 * Add a class to the classes array
	 * It is recommend to pass an array, even for 1 item. Example: array('myclass')
	 * @var class Array The array of classes (or class) to add to the public _classes array
	 */
	public function addBodyClass($class)
	{
		if ( ! empty($class) ) {
			// if array, loop and add each class
			if ( is_array($class) ) {
				/*
				foreach( $class as $item ) {
					$this->_classes[] = $item;
				}*/
				array_merge($this->_classes, $class);
			} else {
				$this->_classes[] = $class;
			}
		}
	}

	/**
	 * A wrapper to return the _classes array
	 * @return Array _classes
	 */
	public function getBodyClass()
	{
		return $this->_classes;
	}

	/**
	 * A clean wrapper for echoBodyClasses()
	 * This does the same thing, only the function name is more appropriate from the view side
	 * The is the preferred function to use to add your classes to your body tag
	 */
	public function echoBodyClass()
	{
		$this->echoBodyClasses(true);	// hard-coded for future proof
	}

	/**
	 * Echo out the body classes array
	 * By default, it will include the class="" tag unless specified.
	 * This loops through the _classes array and prints out like this: class="myclass1 myclass2"
	 * Use this in your layout or view files, wherever your body tag is in your HTML template
	 * Example: <body <?php $this->echoBodyClasses(); ?>>
	 *
	 * @param String showTag (optional default=true) Whether or not to echo the HTML class="" tag
	 */
	public function echoBodyClasses($showTag=true)
	{
		$classString = '';

		// should be an array
		if ( is_array($this->getBodyClass()) ) {
			foreach ( $this->getBodyClass() as $key => $val ) {
				$prefix = ($key == 0 ) ? '' : ' ';
				$classString .= $prefix . $val;
			}
		} else {
			// if its a string, support it too (just in case)
			$classString = $this->getBodyClass();
		}

		if ($showTag === false) {
			echo $classString;
		} else {
			echo 'class="' . $classString . '"';
		}
		
	}

	/**
	 * Returns the 'defaultBodyClass' param from your '/protected/config/main.php'
	 * If it is not set, the default classes array will be empty.
	 * If it is not an array, it is converted to an array
	 * @return param Returns the defaultBodyClass array
	 */
	public function getDefaultBodyClass()
	{
		$param = Yii::app()->params['defaultBodyClass'];
		
		if ( ! isset($param) && empty($param) ) {
			return array();
		}
		
		if ( ! is_array($param) ) {
			$param = array($param);
		}

		return $param;
	}

	/**
	 * Loads a default (custom) class to use for the EasyBodyClass Behavior
	 * Gets a custom class array from your '/protected/config/main.php' params to use as the default class
	 * @return Array param Returns an array of the default custom class
	 */
	public function getDefaultCustomClass($paramName)
	{
		$param = Yii::app()->params[$paramName];
		
		if ( ! isset($param) && empty($param) ) {
			return array();
		}
		
		if ( ! is_array($param) ) {
			$param = array($param);
		}

		return $param;
	}

	/**
	 * Loads the defaults for the EasyBodyClass Behavior
	 * This grabs the 'defaultBodyClass' from your '/protected/config/main.php' params to use as the default class
	 * @return true
	 */
	public function initBodyClass($defaultParam=null)
	{
		$defaultClass = null;

		if ( isset($defaultParam) ) {
			$defaultClass = $this->getDefaultCustomClass($defaultParam);
		} else {
			$defaultClass = $this->getDefaultBodyClass();
		}
		
		$this->setBodyClass($defaultClass);
		return true;
	}	
}