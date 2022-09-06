<?php
namespace view;

use framework\mvc\IView;

class RedirectView implements IView
{
	private $url;
	private $window;

	public function __construct($url, $window = "window")
	{
		$this->url = $url;
		$this->window = $window;
		$this->display();
	}
	
	public function display()
	{
		if ($this->window=="top")
		{
			echo "<script type=\"text/javascript\">\ntop.location.href = \"{$this->url}\";\n</script>";
		}
		else {
			header('Location: ' . $this->url);
		}
	}
}