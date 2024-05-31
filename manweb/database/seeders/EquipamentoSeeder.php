<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipamento;

class EquipamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {



        Equipamento::create([
            'nome' => 'Usina de Asfalto UAG 60/80 t/h',
            'descricao' => 'Usina de Asfalto ',
            'marca_id' => '6',
        ]);

        Equipamento::create([
            'nome' => 'Filtro de mangas',
            'descricao' => 'Filtro de mangas da Usina ',
            'marca_id' => '6',
        ]);

        Equipamento::create([
            'nome' => 'exaustor do filtro de mangas',
            'descricao' => 'exaustor sucção central',
            'marca_id' => '6',

        ]);

        Equipamento::create([
            'nome' => 'misturador duplo eixo ',
            'descricao' => 'Misturado duplo eixo com redutora simples e correntão',
            'marca_id' => '1',

        ]);

        Equipamento::create([
            'nome' => 'Peneira 60/80 t/h',
            'descricao' => 'peneira com 4 telas da usina de asfalto ',
            'marca_id' => '1',

        ]);

        Equipamento::create([
            'nome' => 'elevador de canecas',
            'descricao' => 'elevador de agregados com canecas, vertical',
            'marca_id' => '1'
        ]);

        Equipamento::create([
            'nome' => 'Caldeira',
            'descricao' => 'Caldeira, aquecedor térmico',
            'marca_id' => '1'
        ]);

        Equipamento::create([
            'nome' => 'TANQUE DE CAP 01',
            'descricao' => 'tANQUE DE CAP 01, CAPACIDADE: 30.000 KG',
            'marca_id' => '1'
        ]);

        Equipamento::create([
            'nome' => 'TANQUE DE CAP 02',
            'descricao' => 'TANQUE DE CAP 02, CAPACIDADE: 28.000 KG',
            'marca_id' => '1'
        ]);

        Equipamento::create([
            'nome' => 'TANQUE DE COMBUSTÍVEL PESADO',
            'descricao' => 'TANQUE QUE ARMAZENA ÓLEO PARA O MAÇARICO DA USINA',
            'marca_id' => '1'
        ]);

        Equipamento::create([
            'nome' => 'COMPRESSOR DE AR 01',
            'descricao' => 'COMPRESSOR DE AR SHULZ',
            'marca_id' => '1'
        ]);

        Equipamento::create([
            'nome' => 'COMPRESSOR DE AR 02',
            'descricao' => 'COMPRESOSR DE AR SHULZ',
            'marca_id' => '1'
        ]);

    }
}
