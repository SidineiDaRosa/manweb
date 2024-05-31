<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnidadeMedida;


class UnidadeMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnidadeMedida::create([
            'nome'=>'KG',//1
            'descricao'=>'Kilograma usado para pesos'
        ]);

        UnidadeMedida::create([
            'nome'=>'L',//2
            'descricao'=>'Litro, usado para medir líquidos'
        ]);

        UnidadeMedida::create([
            'nome'=>'M',//3
            'descricao'=>'Metro, usado para medir distâncias'
        ]);
        UnidadeMedida::create([
            'nome'=>'mm',//4
            'descricao'=>'milímetro, usado para medir distâncias'
        ]);
        UnidadeMedida::create([
            'nome'=>'TON',//5
            'descricao'=>'Usado para medir pesos em grande quantidade'
        ]);
        UnidadeMedida::create([
            'nome'=>'KW/H',//5
            'descricao'=>'kILOWATS/HORA UTILIZADO PARA MEDIR ENERGIA ELÉTRICA'
        ]);
    }
}
