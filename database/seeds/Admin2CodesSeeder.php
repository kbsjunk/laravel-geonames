<?php

class Admin2CodesSeeder extends CsvSeeder {

	public function __construct()
	{
		$this->table = 'admin2_codes';
		$this->filename = storage_path('geonames/admin2Codes.txt');
		
		$this->csv_delimiter = "\t";

		$this->mapping = [
			0 => 'code',
			1 => 'name',
			2 => 'name_ascii',
			3 => 'geoname_id',
		];
	}

	public function before()
	{
		$this->truncate();
	}

	public function processRow(array $row)
	{
		$fields = explode('.', $row['code']);

		$extra = [
			'country_code' => $fields[0],
			'admin1_code' => $fields[0].'.'.$fields[1],
			'iso_code'  => @$fields[2] != $row['geoname_id'] ? $fields[2] : null,
		];

		return array_merge($row, $extra);
	}

}