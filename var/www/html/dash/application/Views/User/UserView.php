<?php

namespace Views\User;

use Core\View;

class UserView extends View
{

	public function __construct($title, $template)
	{
		$this->title = $title;
		$this->templateLayout = $template;
	}
}