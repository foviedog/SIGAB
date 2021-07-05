<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User();
        $user->persona_id = '602000054'; //Karla
        $user->password = 'Admin12345';
        $user->rol = 1;
        $user->save();

        $user = new \App\User();
        $user->persona_id = '603280253';//Juan pablo
        $user->password = 'Admin12345';
        $user->rol = 2;
        $user->save();

        $user = new \App\User();
        $user->persona_id = '401500844';//Jenny Ulate
        $user->password = 'Admin12345';
        $user->rol = 4;
        $user->save();

        $user = new \App\User();
        $user->persona_id = '107090236'; // Lucrecia
        $user->password = 'Admin12345';
        $user->rol = 3;
        $user->save();

        $user = new \App\User();
        $user->persona_id = '108450068'; //Magally
        $user->password = 'Admin12345';
        $user->rol = 4;
        $user->save();

        $user = new \App\User();
        $user->persona_id = '110770945'; //Freddy Oviedo
        $user->password = 'Admin12345';
        $user->rol = 4;
        $user->save();

        $user = new \App\User();
        $user->persona_id = '502610008'; //Diley Batista
        $user->password = 'Admin12345';
        $user->rol = 5;
        $user->save();

        $user = new \App\User();
        $user->persona_id = '401680488'; //Carolina Sanchez
        $user->password = 'Admin12345';
        $user->rol = 6;
        $user->save();

        $user = new \App\User();
        $user->persona_id = '207700755'; //Lineth Cubero
        $user->password = 'Admin12345';
        $user->rol = 7;
        $user->save();

        $user = new \App\User();
        $user->persona_id = '107490898'; //Giannina Ocampo Bermudez
        $user->password = 'Admin12345';
        $user->rol = 7;
        $user->save();

        $user = new \App\User();
        $user->persona_id = '305240828'; //Valeria De Fátima Ramírez León
        $user->password = 'Admin12345';
        $user->rol = 7;
        $user->save();
    }
}
