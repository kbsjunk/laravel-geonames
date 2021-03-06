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
		$this->truncate();
	}

	public function after()
	{
		$this->delete(function($query) {
			$query->where('code', 'null');
		});
	}

	public function processRow(array $row)
	{
		$fields = explode('.', $row['code']);

		$extra = [
			'feature_class' => $fields[0],
			'feature_code'  => @$fields[1] ?: 'null',
		];

		return array_merge($row, $extra);
	}

}