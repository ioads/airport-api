<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Array de aeroportos com city_id, name e iata_code
        $airports = [
            // Aeroportos de Recife (PE)
            ['city_id' => 1, 'name' => 'Aeroporto Internacional do Recife', 'iata_code' => 'REC'],

            // Aeroportos de Salvador (BA)
            ['city_id' => 2, 'name' => 'Aeroporto Internacional de Salvador', 'iata_code' => 'SSA'],

            // Aeroportos de Fortaleza (CE)
            ['city_id' => 3, 'name' => 'Aeroporto Internacional de Fortaleza', 'iata_code' => 'FOR'],

            // Aeroportos de Natal (RN)
            ['city_id' => 4, 'name' => 'Aeroporto Internacional de Natal', 'iata_code' => 'NAT'],

            // Aeroportos de João Pessoa (PB)
            ['city_id' => 5, 'name' => 'Aeroporto Internacional de João Pessoa', 'iata_code' => 'JPA'],

            // Aeroportos de Maceió (AL)
            ['city_id' => 6, 'name' => 'Aeroporto Internacional de Maceió', 'iata_code' => 'MCZ'],

            // Aeroportos de São Luís (MA)
            ['city_id' => 7, 'name' => 'Aeroporto Internacional de São Luís', 'iata_code' => 'SLZ'],

            // Aeroportos de Teresina (PI)
            ['city_id' => 8, 'name' => 'Aeroporto Senador Petrônio Portella', 'iata_code' => 'THE'],

            // Aeroportos de Aracaju (SE)
            ['city_id' => 9, 'name' => 'Aeroporto Internacional de Aracaju', 'iata_code' => 'AJU'],

            // Aeroportos de São Paulo (SP)
            ['city_id' => 10, 'name' => 'Aeroporto de Congonhas', 'iata_code' => 'CGH'],
            ['city_id' => 10, 'name' => 'Aeroporto Internacional de Guarulhos', 'iata_code' => 'GRU'],

            // Aeroportos do Rio de Janeiro (RJ)
            ['city_id' => 11, 'name' => 'Aeroporto Santos Dumont', 'iata_code' => 'SDU'],
            ['city_id' => 11, 'name' => 'Aeroporto Internacional do Rio de Janeiro - Galeão', 'iata_code' => 'GIG'],

            // Aeroportos de Belo Horizonte (MG)
            ['city_id' => 12, 'name' => 'Aeroporto de Confins', 'iata_code' => 'CNF'],
            ['city_id' => 12, 'name' => 'Aeroporto da Pampulha', 'iata_code' => 'PLU'],

            // Aeroportos de Vitória (ES)
            ['city_id' => 13, 'name' => 'Aeroporto de Vitória', 'iata_code' => 'VIX'],
        ];

        // Inserir os dados na tabela "airports"
        DB::table('airports')->insert($airports);
    }
}
