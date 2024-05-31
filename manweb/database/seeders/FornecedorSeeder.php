<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fornecedor;

class FornecedorSeeder extends Seeder

{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fornecedor::create([
            'razao_social' => 'Greca Distribuidora de Asfalto Ltda',
            'nome_fantasia' => 'Greca Distribuidora de Asfalto Ltda',
            'cnpj' => '02.351.006/0003-09',
            'insc_estadual' => '0430086326',
            'endereco' => 'Rua Bento Gonsalves, 1850',
            'bairro'=>'',
            'cidade'=>'Esteio',
            'estado'=>'RS',
            'telefone'=>'5134735020',
            'contato'=>'',
            'email'=>'',
            'site'=>''
        ]);
        Fornecedor::create([
            'razao_social' => 'Terraplanagem Bresola',
            'nome_fantasia' => 'Terraplanagem Bresola',
            'cnpj' => '000000000000000',
            'insc_estadual' => '00000000000',
            'endereco' => 'Rua Bento Gonsalves, 1850',
            'bairro'=>'',
            'cidade'=>'Campos Novos',
            'estado'=>'SC',
            'telefone'=>'5134735020',
            'contato'=>'Dario Bresola',
            'email'=>'',
            'site'=>'www.bresolaterraplanagem.com.br'
        ]);

        Fornecedor::create([
            'razao_social' => 'Coopercampos coperativa s/a',
            'nome_fantasia' => 'Coopercampos',
            'cnpj' => '000000000000000',
            'insc_estadual' => '00000000000',
            'endereco' => 'Rua Bento Gonsalves, 1850',
            'bairro'=>'',
            'cidade'=>'Campos Novos',
            'estado'=>'SC',
            'telefone'=>'5134735020',
            'contato'=>'',
            'email'=>'',
            'site'=>''
        ]);

        Fornecedor::create([
            'razao_social' => 'Ciber equipamentos Rodoviários SA',
            'nome_fantasia' => 'Ciber',
            'cnpj' => '000000000000000',
            'insc_estadual' => '00000000000',
            'endereco' => 'Rua Bento Gonsalves, 1850',
            'bairro'=>'',
            'cidade'=>'POrto Alegre',
            'estado'=>'RS',
            'telefone'=>'5134735020',
            'contato'=>'',
            'email'=>'',
            'site'=>''
        ]);
    }
}
