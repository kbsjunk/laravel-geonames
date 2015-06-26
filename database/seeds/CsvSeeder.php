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
}