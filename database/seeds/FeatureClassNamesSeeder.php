<?php

class FeatureClassNamesSeeder extends CsvSeeder {

	protected $language;

	public function __construct()
	{
		$this->language = $this->command->option('language');

		$this->table = 'feature_code_names';
		$this->filename = storage_path('geonames/featureCodes_'.$this->language.'.txt');
		
		$this->csv_delimiter = "\t";

		$this->mapping = [
			0 => 'code',
			1 => 'name',
			// 2 => 'description',
		];
	}

	public function before()
	{
		// $this->truncate();
	}

	public function after()
	{
		$this->delete(function($query) {
			$query->where('code', 'null');
		});
	}

	public function processRow(array $row)
	{
		$extra = [
			'language' => $this->language
		];

		return array_merge($row, $extra);
	}

}