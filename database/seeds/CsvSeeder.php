<?php

use Flynsarmy\CsvSeeder\CsvSeeder as BaseCsvSeeder;

class CsvSeeder extends BaseCsvSeeder {

	public function __construct()
	{
		$this->table = 'your_table';
		$this->filename = base_path().'/database/seeds/csvs/your_csv.csv';
	}

	public function run()
	{
		DB::disableQueryLog();

		if ($this->truncate) DB::table($this->table)->truncate();

		parent::run();
	}
}