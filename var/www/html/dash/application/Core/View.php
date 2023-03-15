<?php

class View
{

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

	/**
	 * @throws Exception
	 */
	public function render($template, $data = null): void
  {

    $this->generateCSRFToken();
    include $_SERVER['DOCUMENT_ROOT'] . '/application/templates/' . $template;
  }

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
}