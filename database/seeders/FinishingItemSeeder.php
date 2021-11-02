<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinishingItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ['Laminating', 'Varnish', 'Varnish Mesin', 'Jahit', 'Plastik', 'Packaging']
        $data = [
            [
                'category_id' => 1,
                'items' => ['Doff 1 Muka', 'Doff 2 Muka', 'Glossy 1 Muka', 'Glossy 2 Muka', 'Piso', 'Rel', 'Jasa Pon', 'Perforasi']
            ],
            [
                'category_id' => 2,
                'items' => ['Doff 1 Muka', 'Doff 2 Muka', 'Glossy 1 Muka', 'Glossy 2 Muka']
            ],
            [
                'category_id' => 3,
                'items' => ['Doff 1 Muka', 'Doff 2 Muka', 'Glossy 1 Muka', 'Glossy 2 Muka']
            ],
            [
                'category_id' => 4,
                'items' => ['Kawat', 'Benang']
            ],
            [
                'category_id' => 5,
                'items' => ['Sealking', 'Wrapping', 'Mica']
            ],
            [
                'category_id' => 6,
                'items' => ['Hook', 'Tali', 'Double Tap', 'Packing', 'Tinta']
            ],
            [
                'category_id' => 7,
                'items' => ['Emboss', 'Jaket Kulit', 'Jasa Komplit', 'Jilid Buku', 'Biaya Kirim', 'Lem', 'Potong Pas', 'Cutting Sticker', 'Lipat', 'Mata Ayam', 'Numerator', 'Ongkos Kirim', 'Perfect Binding', 'Sablon', 'Spiral', 'Waterbase', 'Spot UV', 'Poly']
            ],

        ];

        $data = collect($data)->flatMap(function ($master) {
            return collect($master['items'])->map(function ($item) use ($master) {
                return [
                    'finishing_item_category_id' => $master['category_id'],
                    'name' => $item,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
            });
        })->all();

        DB::table('finishing_items')->insert($data);
    }
}
