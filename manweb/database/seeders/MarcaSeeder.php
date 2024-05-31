<?php


namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Marca;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Marca::create([
            'nome'=>'Ciber',//1
            'descricao'=>'Equipamentos rodoviários'
        ]);

        Marca::create([
            'nome'=>'Caterpillar',//2
            'descricao'=>'Equipamentos de Terraplanagem'
        ]);

        Marca::create([
            'nome'=>'Arauterm',//3
            'descricao'=>'Caldeiras e aquecedores'
        ]);

        Marca::create([
            'nome'=>'Faço',//4
            'descricao'=>'Britadores'
        ]);

        Marca::create([
            'nome'=>'Komatsu',//5
            'descricao'=>'Carregadeiras e maquinas pesadas'
        ]);

        Marca::create([
            'nome'=>'DESCONHECIDA',//6
            'descricao'=>'Desconhecida'
        ]);

        Marca::create([
            'nome'=>'SHULZ',//7
            'descricao'=>'COMPRESSORES'
        ]);

        Marca::create([
            'nome'=>'WEG',//8
            'descricao'=>'MOTORES ELÉTRICOS'
        ]);

        Marca::create([
            'nome'=>'CELESC',//9
            'descricao'=>'DISTRIBUIDORA DE ENERGIA ELÉTRICA'
        ]);
    }
}
