<?php

namespace App\Http\Traits\Mobile;

use App\Exceptions\BusinessException;
use Illuminate\Http\JsonResponse;
use Exception;

trait ListOperation
{
    /**
     * @throws BusinessException
     */

    public function index(): JsonResponse
    {
        try {
            $this->getParams();
            $this->setupListOperation();
            $model = app($this->model);
            if (!empty($this->params)) {
                $model->search($this->params);
            }
            $data = $model->list($this->params);


            $data['paginate'] = $this->_paginate($data['list']);
            if ($this->resource) {
                $data['list'] = $this->resource::collection($data['list']);
            }

            $this->setCode(200);
            $this->setMessage('OK');
            $this->setResult('list', $data['list']);
            $this->setResult('paginate', $data['paginate']);
            return $this->returnResults();

        } catch (Exception $e) {
            report($e);
            throw new BusinessException($e->getMessage());
        }
    }

    /**
     * Get parameter for filter
     */
    public function getParams(): void
    {
        $this->params['page'] = request()->get('page', 1);
        $this->params['search'] = request()->get('search', '');
        $this->params['limit'] = request()->get('limit', config('custom.crud.list.limit'));
        $this->params['order'] = request()->get('order', config('custom.crud.list.order'));
        $this->params['sort'] = request()->get('sort', config('custom.crud.list.sort'));
        $this->addParams();
    }

    /**
     * Mapping parameter
     *
     * @param $params
     */
    public function mapParams($params): void
    {
        foreach ($params as $key => $param) {
            $this->params[$key] = $param;
        }
    }

    protected function setupListOperation()
    {
    }

    protected function addParams()
    {
    }

}
