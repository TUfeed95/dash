<?php

namespace Models;

interface DataMapperInterface
{
	public function create($model);
	public function update($model);
	public function remove();
	public function getById($id);
}