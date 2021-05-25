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
        $persona = new \App\Persona();
        $persona->persona_id = '1';
        $persona->nombre = 'Dirección';
        $persona->apellido = 'Rol';
        $persona->genero = 'Femenino';
        $persona->imagen_perfil = 'default.jpg';
        $persona->estado_civil = 'Casado';
        $persona->direccion_residencia = 'Heredia';
        $persona->save();

        $user = new \App\User();
        $user->persona_id = '1';
        $user->password = '1';
        $user->rol = 1;
        $user->save();

        $persona = new \App\Persona();
        $persona->persona_id = '2';
        $persona->nombre = 'Subdirección';
        $persona->apellido = 'Rol';
        $persona->genero = 'Femenino';
        $persona->imagen_perfil = 'default.jpg';
        $persona->estado_civil = 'Casado';
        $persona->direccion_residencia = 'Heredia';
        $persona->save();

        $user = new \App\User();
        $user->persona_id = '2';
        $user->password = '2';
        $user->rol = 2;
        $user->save();

        $persona = new \App\Persona();
        $persona->persona_id = '3';
        $persona->nombre = 'Académica responsable de Aseguramiento de la Calidad de la Carrera';
        $persona->apellido = 'Rol';
        $persona->genero = 'Femenino';
        $persona->imagen_perfil = 'default.jpg';
        $persona->estado_civil = 'Casado';
        $persona->direccion_residencia = 'Heredia';
        $persona->save();

        $user = new \App\User();
        $user->persona_id = '3';
        $user->password = '3';
        $user->rol = 3;
        $user->save();

        $persona = new \App\Persona();
        $persona->persona_id = '4';
        $persona->nombre = 'Académica responsable de SIGAB';
        $persona->apellido = 'Rol';
        $persona->genero = 'Femenino';
        $persona->imagen_perfil = 'default.jpg';
        $persona->estado_civil = 'Casado';
        $persona->direccion_residencia = 'Heredia';
        $persona->save();

        $user = new \App\User();
        $user->persona_id = '4';
        $user->password = '4';
        $user->rol = 4;
        $user->save();

        $persona = new \App\Persona();
        $persona->persona_id = '5';
        $persona->nombre = 'Asistente administrativa';
        $persona->apellido = 'Rol';
        $persona->genero = 'Femenino';
        $persona->imagen_perfil = 'default.jpg';
        $persona->estado_civil = 'Casado';
        $persona->direccion_residencia = 'Heredia';
        $persona->save();

        $user = new \App\User();
        $user->persona_id = '5';
        $user->password = '5';
        $user->rol = 5;
        $user->save();

        $persona = new \App\Persona();
        $persona->persona_id = '6';
        $persona->nombre = 'Secretaria';
        $persona->apellido = 'Rol';
        $persona->genero = 'Femenino';
        $persona->imagen_perfil = 'default.jpg';
        $persona->estado_civil = 'Casado';
        $persona->direccion_residencia = 'Heredia';
        $persona->save();

        $user = new \App\User();
        $user->persona_id = '6';
        $user->password = '6';
        $user->rol = 6;
        $user->save();

        $persona = new \App\Persona();
        $persona->persona_id = '7';
        $persona->nombre = 'Estudiante asistente académica';
        $persona->apellido = 'Rol';
        $persona->genero = 'Femenino';
        $persona->imagen_perfil = 'default.jpg';
        $persona->estado_civil = 'Casado';
        $persona->direccion_residencia = 'Heredia';
        $persona->save();

        $user = new \App\User();
        $user->persona_id = '7';
        $user->password = '7';
        $user->rol = 7;
        $user->save();
    }
}