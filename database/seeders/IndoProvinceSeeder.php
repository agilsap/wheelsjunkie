<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Flynsarmy\CsvSeeder\CsvSeeder;
use DB;

class IndoProvinceSeeder extends CsvSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function __construct()
	{
		$this->table = 'indo_province';
        $this->filename = base_path().'/database/seeders/doc/dataprovinsi.csv';
        $this->csv_delimiter = ';';
        $this->mapping = [
            0 => 'province_id',
            1 => 'province',
            2 => 'city',
            3 => 'district',
            4 => 'sub_district',
            5 => 'zip_code',
        ];
	}

	public function run()
	{
		// Recommended when importing larger CSVs
		DB::disableQueryLog();

		// Uncomment the below to wipe the table clean before populating
		DB::table($this->table)->truncate();

		parent::run();
	}
}
