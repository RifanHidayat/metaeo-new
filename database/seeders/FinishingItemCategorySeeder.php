<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinishingItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = collect(['Laminating', 'Varnish', 'Varnish Mesin', 'Jahit', 'Plastik', 'Packaging', 'Other'])
            ->map(function ($item) {
                return [
                    'name' => $item,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
            })->all();
        DB::table('finishing_item_categories')->insert($data);
    }
}
