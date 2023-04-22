<?php

namespace Core;

use Exception;
use Models\User\User;

class View
{

	public $title;
	public $content;
	public $layout;

	/**
	 * Ответ на запрос с js
	 * @param array $result
	 * @return void
	 */
	public function response(array $result): void
	{
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	/**
	 * @throws Exception
	 */
	protected function generateCSRFToken(): void
	{
		define('LENGTH_RANDOM_BYTES', 35);

		try {
			$_SESSION['csrf_token'] = bin2hex(random_bytes(LENGTH_RANDOM_BYTES));
		} catch (Exception $e) {
			throw new Exception("Произошла ошибка при генерации csrf-токена: " . $e->getMessage());
		}
	}

	public function renderContent($template, $data=[])
	{
		$templatePath = $_SERVER['DOCUMENT_ROOT'] . '/application/templates/' . $template;

		ob_start();

		if (file_exists($templatePath)) {
			extract($data);
			require $templatePath;
			$this->content = ob_get_contents();
		}

		ob_end_clean();

		return $this->content;
	}

	/**
	 * @throws Exception
	 */
	public function render()
	{
		$layout = $_SERVER['DOCUMENT_ROOT'] . '/application/templates/' . $this->layout;

		$data['title'] = $this->title;
		$data['content'] = $this->content;
		$data['currentUser'] = (new User())->currentUser();

		if (file_exists($layout)) {
			extract($data);
			include $layout;
		}
	}

	public function renderForm($templateForm)
	{
		$this->generateCSRFToken();

	}
}