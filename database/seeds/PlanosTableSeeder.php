<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('planos')->insert([
            'nome' => 'Plano A',
            'valor' => 10,
            'descricao' => 'A wonderful serenity has taken possession of my entire soul.',
            'diferencial' => '<ul class="pl-3"><li>One</li><li>Two</li><li>Three</li></ul>',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('planos')->insert([
            'nome' => 'Plano B',
            'valor' => 20,
            'descricao' => 'I sink under the weight of the splendour of these visions!',
            'diferencial' => '<ul class="pl-3"><li>Four</li><li>Five</li><li>Six</li></ul>',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('planos')->insert([
            'nome' => 'Plano C',
            'valor' => 30,
            'descricao' => 'I feel the presence of the Almighty, who formed us in his own image.',
            'diferencial' => '<ul class="pl-3"><li>Seven</li><li>Eight</li><li>Nine</li></ul>',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
