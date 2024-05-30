<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produto;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Produto::create([
            'nome'=>'CAP 50/70',//1
            'descricao'=>'Cimento Asfático de Petróleo',
            'marca_id'=>'1',
            'unidade_medida_id'=>'1',
            'categoria_id'=>'1',
            'estoque_minimo'=>'8000',
            'estoque_ideal'=>'8000',
            'estoque_maximo'=>'50000',
        ]);
        Produto::create([
            'nome'=>'DIESEL',//2
            'descricao'=>'ÓLEO COMBUSTIVEL DIESEL',
            'marca_id'=>'1',
            'unidade_medida_id'=>'1',
            'categoria_id'=>'1',
            'estoque_minimo'=>'8000',
            'estoque_ideal'=>'8000',
            'estoque_maximo'=>'50000',
        ]);
        Produto::create([
            'nome'=>'XISTO',//3
            'descricao'=>'ÓLEO DE XISTO',
            'marca_id'=>'1',
            'unidade_medida_id'=>'1',
            'categoria_id'=>'1',
            'estoque_minimo'=>'8000',
            'estoque_ideal'=>'8000',
            'estoque_maximo'=>'50000',
        ]);

        Produto::create([
            'nome'=>'CBUQ FAIXA C',//4
            'descricao'=>'Concreto usinado a quente, MASSA FINA',
            'marca_id'=>'1',
            'unidade_medida_id'=>'1',
            'categoria_id'=>'1',
        ]);

        Produto::create([
            'nome'=>'CBUQ FAIXA A',//5
            'descricao'=>'Concreto usinado a quente, MASSA GROSSA',
            'marca_id'=>'1',
            'unidade_medida_id'=>'1',
            'categoria_id'=>'1',
        ]);

        Produto::create([
            'nome'=>'CBUQ BINDER',//6
            'descricao'=>'Concreto usinado a quente, MASSA GROSSA',
            'marca_id'=>'1',
            'unidade_medida_id'=>'1',
            'categoria_id'=>'1',
        ]);

        Produto::create([
            'nome'=>'CBUQ FAIXA A',//7
            'descricao'=>'Concreto usinado a quente, MASSA GROSSA',
            'marca_id'=>'1',
            'unidade_medida_id'=>'1',
            'categoria_id'=>'1',
        ]);
        Produto::create([
            'nome'=>'ENERGIA ELÉTRICA',//8
            'descricao'=>'ENERGIA ELÉTRICA',
            'marca_id'=>'9',
            'unidade_medida_id'=>'5',
            'categoria_id'=>'7',
        ]);

    }
}
