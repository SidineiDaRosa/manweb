<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::create([
            'nome'=>'PEÇAS DE EQUIPAMENTOS',//1
            'descricao'=>'Peças usadas nos equipamentos'
        ]);

        Categoria::create([
            'nome'=>'MINÉRIOS',//2
            'descricao'=>'PRODUTOS EXTRAÍDOS DE MINÉRIOS'
        ]);

        Categoria::create([
            'nome'=>'COMBUSTÍVEIS',//3
            'descricao'=>'COMBUSTIVEIS DE QUEIMA NOS EQUIPAMENTOS'
        ]);

        Categoria::create([
            'nome'=>'ALIMENTOS',//4
            'descricao'=>'ALIMENTOS'
        ]);

        Categoria::create([
            'nome'=>'HIGIENE E LIMPEZA',//5
            'descricao'=>'PRODUTOS PARA HIGIENE E LIMPEZA'
        ]);

        Categoria::create([
            'nome'=>'ASFALTO',//6
            'descricao'=>'CBUQ'
        ]);

        Categoria::create([
            'nome'=>'ENERGIA ELÉTRICA',//7
            'descricao'=>'ENERGIA ELÉTRICA'
        ]);
    }
}
