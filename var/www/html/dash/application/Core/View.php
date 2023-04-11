<?php
namespace Core;
use Exception;
use HttpException;

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
	public function renderContent($template, $data = []): bool|string
	{
		$pathTemplate = $_SERVER['DOCUMENT_ROOT'] . '/application/templates/' . $template;
		ob_start();
		if (file_exists($pathTemplate)) {
			extract($data);
			require $pathTemplate;
		} else {
			echo "Возникла ошибка во время рендеринга контента.";
		}
		return ob_get_clean();
	}

	/**
	 *
	 * @return void
	 * @throws Exception
	 */
	public function render($content, $template ='layout.php', $data = []): void
	{
		$this->generateCSRFToken();

		$data['content'] = $this->renderContent($content, $data);

		extract($data);

		include $_SERVER['DOCUMENT_ROOT'] . '/application/templates/' . $template;
	}

}