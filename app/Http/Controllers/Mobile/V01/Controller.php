<?php

namespace App\Http\Controllers\Mobile\V01;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $entity_name;
    protected $entity_name_plural;
    protected $model;
    protected $resource;
    protected $request;
    protected $fields = [];

    public function __construct()
    {
        if ($this->model) {
            return;
        }

        $this->setup();
    }


    public function setup()
    {
    }

    public function setValidation($class): void
    {
        $this->request = $class;
    }

    public function setResource($resource): void
    {
        $this->resource = $resource;
    }

    public function setModel($model): void
    {
        $this->model = $model;
    }

    public function setFields($fields): void
    {
        $this->fields = $fields;
    }

    public function setEntityNameStrings($singular, $plural): void
    {
        $this->entity_name = $singular;
        $this->entity_name_plural = $plural;
    }

    protected array $_errors = [];

	public function getErrors(): array
	{
		return $this->_errors;
	}

	/**
	 * @param object|int|array|string|null $errors
	 */
	public function setError(object|int|array|string|null $errors): void
	{
		$this->_errors[] = $errors;
	}

	protected int $_code = 400;

	public function setCode($code): void
	{
		$this->_code = $code;
	}

	public function getCode(): int
	{
		return $this->_code;
	}

	protected mixed $_message = null;

	public function setMessage($msg): void
	{
		$this->_message = $msg;
	}

	public function getMessage()
	{
		return $this->_message;
	}

	protected array $_result = [];

	/**
	 * @param string|null $name
	 * @return array|string|null|mixed
	 */
	public function getResult(string $name = null): mixed
	{
		if ($name === null || $name === '') {
			return $this->_result;
		}
		if (isset($this->_result[$name])) {
			return $this->_result[$name];
		}
		return null;
	}

	/**
	 * @param string $name
	 * @param mixed $value
	 */
	public function setResult(string $name, mixed $value): void
	{
		if (!empty($name)) {
			$this->_result[$name] = $value;
		}
	}

	/**
	 * @param array|string $errors
	 * @param int $code
	 * @return JsonResponse
	 */
	public function returnError(array|string $errors, int $code = 400): JsonResponse
	{
		$errorMsg = $errors;
		if (is_array($errors)) {
			foreach ($errors as $error) {
				if (is_array($error)) {
					foreach ($error as $err) {
						$errorMsg = $err;
						break;
					}
				}
				else {
					$errorMsg = $error;
				}
				break;
			}
		}
		$this->setCode($code);
		$this->setMessage($errorMsg);
		$this->setError($errors);
		return $this->returnResults();
	}

	protected function returnResults($httpHeaderStatusCode = 200): JsonResponse
	{
		$results = [];
		$results['code'] = $this->getCode();
		$results['message'] = __($this->getMessage()) ?? 'OK';
		$results['data'] = !empty($this->getResult()) ? $this->getResult() : null;
		$results['errors'] = $this->getErrors();
		return response()->json($results, $httpHeaderStatusCode);
	}
}
