<?php

use Flynsarmy\CsvSeeder\CsvSeeder as BaseCsvSeeder;

abstract class CsvSeeder extends BaseCsvSeeder {

	public function before() {}

	public function run()
	{
		$this->before();

		DB::disableQueryLog();

		parent::run();

		$this->after();
	}

	public function after() {}

	public function truncate()
	{
		DB::table($this->table)->truncate();
	}

	public function delete(callable $where)
	{
		DB::table($this->table)->where($where)->delete();
	}

	public function readRow(array $row, array $mapping, callable $after = null)
	{
		return $this->processRow(parent::readRow($row, $mapping));
	}

	public function processRow(array $row)
	{
		return $row;
	}
}