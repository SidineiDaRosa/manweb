<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProdutoFornecedor;

class ProdutoFornecedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProdutoFornecedor::create([
            'produto_id'=>'1',
            'fornecedor_id'=>'1'
        ]);

        ProdutoFornecedor::create([
            'produto_id'=>'2',
            'fornecedor_id'=>'1'
        ]);

        ProdutoFornecedor::create([
            'produto_id'=>'3',
            'fornecedor_id'=>'1'
        ]);

        ProdutoFornecedor::create([
            'produto_id'=>'4',
            'fornecedor_id'=>'1'
        ]);

        ProdutoFornecedor::create([
            'produto_id'=>'1',
            'fornecedor_id'=>'2'
        ]);

        ProdutoFornecedor::create([
            'produto_id'=>'2',
            'fornecedor_id'=>'2'
        ]);

        ProdutoFornecedor::create([
            'produto_id'=>'4',
            'fornecedor_id'=>'2'
        ]);
    }
}
