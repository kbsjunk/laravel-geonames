<?php

class FeatureClassSeeder extends CsvSeeder {

	public function __construct()
	{
		$this->table = 'feature_codes';
		$this->filename = storage_path('geonames/featureCodes_en.txt');
		
		$this->csv_delimiter = "\t";

		$this->mapping = [
			0 => 'code',
			1 => 'name',
			2 => 'description',
		];
	}

	public function before()
	{
		DB::table('feature_codes')->truncate();
		DB::table('feature_code_names')->truncate();
	}

	public function after()
	{
		
	}

}