<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosFacturasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estados_factura')->insert([
            'descripcion' => 'Vigente',
        ]);
        DB::table('estados_factura')->insert([
            'descripcion' => 'Pagado',
        ]);
        DB::table('estados_factura')->insert([
            'descripcion' => 'Vencido',
        ]);
    }
}
