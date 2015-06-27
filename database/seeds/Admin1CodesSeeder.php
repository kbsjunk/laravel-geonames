<?php

class Admin1CodesSeeder extends CsvSeeder {

	public function __construct()
	{
		$this->table = 'admin1_codes';
		$this->filename = storage_path('geonames/admin1CodesASCII.txt');
		
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
			'fips_code'  => @$fields[1] != $row['geoname_id'] ? $fields[1] : null,
		];

		return array_merge($row, $extra);
	}

}