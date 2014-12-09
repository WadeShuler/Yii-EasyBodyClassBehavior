Yii-EasyBodyClassBehavior
=========================

This Yii Behavior is an easy, effective, and logical way to dynamically set classes on the body tag in your layouts.

##  Why?
I originally just wanted a way to set the class on my body tag (located in my layout) from my UserController. I needed a nice way to use a different body class on the login page.

I found a behavior out there (https://github.com/KingYes/yii-body-classes), but it only generated classes based on the URL. I feel that is a pretty chincy hack, and I don't want my classes looking ugly with my URLs chopped up like that.

This will let you add or set classes right in your Controller's action(). Each action could have different body classes! Alternatively, you could attach this to your main Controller and run this globally!

Supports default classes defined in your Yii config params! All you have to open is your config to change the body class defaults!

Uses Yii Behaviors attached to individual Controllers. You could put the beforeAction() in your '/protected/components/Controller.php' to apply this behavior globally to all Controllers. I prefer to add it to my Controllers individually to only use it when/where I want to. I don't think this really needs to hijack every controller site wide. Though your use/thoughts may vary.


## How to Install
Extract the extension to your extensions folder as `'/protected/extensions/EasyBodyClass'`

Add your default/global classes to the 'defaultBodyClass' param in your `'/protected/config/main.php'` params array:

	'params'=>array(
		'defaultBodyClass' => array('bodyclass', 'another-class'),
	);

_NOTE: If the param is not found, an empty array will be used._


Add the behavior to your `'/protected/components/Controller.php'` or to your Controller (ie: UserController.php)

	public function behaviors()
	{
		return array(
			'EasyBodyClassBehavior' => array(
				'class' => 'ext.EasyBodyClass.EasyBodyClassBehavior'
			),

		);
	}
	

Add the beforeAction() to your Controller (ie: UserController.php). You will need to add this to every controller you want to run this behavior on, so we don't hijack everything. Alternatively, you could add this to your `'/protected/components/Controller.php'` to use this globally.

	protected function beforeAction($action)
	{
		$this->initBodyClass();
		return parent::beforeAction($action);
	}
	
	
Now, to use it, simply add the call to your body tag in your layouts:

`<body <?php $this->echoBodyClass(); ?>>`



The classes you have set as your defaults ( 'defaultBodyClass' array in your `'/protected/config/main.php'` params) will
be echo'd out for you.

In this example, as: `<body class="bodyclass another-class">`



## Further Use
Let's take that even deeper. What if you wanted pre-defined classes for different types of pages. Such as your login page or registration page?

You can define your default classes for those too, load it in the specific action, and it will be automatically added for you.


Here is an example to set the default classes for your login page.

Add your desired custom classes to the params:

    'params'=>array(
		'defaultBodyClass' => array('bodyclass', 'another-class'),	// this was our default as above
        'defaultLoginClass' => array('login-page'),		// our custom class for the login page
	);

_NOTE: Using a custom class, such as 'defaultLoginClass' in the example, will over-ride the defaultBodyClass on the action in use!_


Now in your action (such as actionLogin() in your UserController.php) add this:

	$this->setBodyClass( $this->getDefaultCustomClass('defaultLoginClass') );
	
You will have `<body class="login-page">` on your login page.

I hope someone else finds some use for this. It seems the other behavior was popular, and I think more people would want their own custom classes instead of their URL chopped up into peices for the class.