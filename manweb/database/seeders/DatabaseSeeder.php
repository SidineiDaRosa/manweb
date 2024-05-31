<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory(10)->create();

        $this->call(UserSeeder::class);
        $this->call(MarcaSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(UnidadeMedidaSeeder::class);
        $this->call(FornecedorSeeder::class);
        $this->call(ProdutoSeeder::class);
        $this->call(EquipamentoSeeder::class);
        $this->call(UfSeeder::class);
        $this->call(ProdutoFornecedorSeeder::class);

    }
}
