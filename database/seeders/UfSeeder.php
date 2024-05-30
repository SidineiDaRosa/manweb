<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Uf;

class UfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Uf::create([
            'nome'=>'Amazonas',
            'sigla'=>'AM'//1
        ]);

        Uf::create([
            'nome'=>'Acre',
            'sigla'=>'AC'//2
        ]);

        Uf::create([
            'nome'=>'Amapá',
            'sigla'=>'AP'//3
        ]);

        Uf::create([
            'nome'=>'Rio Grande so Sul',
            'sigla'=>'RS'//4
        ]);

        Uf::create([
            'nome'=>'Santa Catarina',
            'sigla'=>'SC'//5
        ]);

        Uf::create([
            'nome'=>'Paraná',
            'sigla'=>'PR'//6
        ]);

        Uf::create([
            'nome'=>'São Paulo',
            'sigla'=>'SP'//7
        ]);

        Uf::create([
            'nome'=>'Rio de Janeiro',
            'sigla'=>'RJ'//8
        ]);

        Uf::create([
            'nome'=>'Espírito Santo',
            'sigla'=>'ES'//9
        ]);

        Uf::create([
            'nome'=>'Bahia',
            'sigla'=>'BH'//10
        ]);

        Uf::create([
            'nome'=>'Sergipe',
            'sigla'=>'SJ'//11
        ]);

        Uf::create([
            'nome'=>'Alagoas',
            'sigla'=>'AL'//12
        ]);

        Uf::create([
            'nome'=>'Pernambuco',
            'sigla'=>'PE'//13
        ]);

        Uf::create([
            'nome'=>'Paraíba',
            'sigla'=>'PB'//14
        ]);

        Uf::create([
            'nome'=>'Rio Grande do Norte',
            'sigla'=>'RN'//15
        ]);

        Uf::create([
            'nome'=>'Ceará',
            'sigla'=>'CE'//16
        ]);

        Uf::create([
            'nome'=>'Piauí',
            'sigla'=>'PI'//17
        ]);

        Uf::create([
            'nome'=>'Maranhão',
            'sigla'=>'MA'//18
        ]);

        Uf::create([
            'nome'=>'Pará',
            'sigla'=>'PA'//19
        ]);

        Uf::create([
            'nome'=>'Roraima',
            'sigla'=>'RR'//20
        ]);

        Uf::create([
            'nome'=>'Tocantins',
            'sigla'=>'TO'//21
        ]);

        Uf::create([
            'nome'=>'Minas Gerais',
            'sigla'=>'MG'//22
        ]);

        Uf::create([
            'nome'=>'Distrito Federal',
            'sigla'=>'DF'//24
        ]);

        Uf::create([
            'nome'=>'Mato Grosso',
            'sigla'=>'MT'//25
        ]);
        Uf::create([
            'nome'=>'Mato Grosso do Sul',
            'sigla'=>'MS'//26
        ]);
        Uf::create([
            'nome'=>'Rondônia',
            'sigla'=>'RO'//27
        ]);

        
    }
}
