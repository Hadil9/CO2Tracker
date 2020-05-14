<?php

use Illuminate\Database\Seeder;
use App\Mode;
use App\Engine;
use App\Program;
use App\User;
use App\Trip;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ModesTableSeeder::class);
        $this->command->info('Mode table seeded!');
        
        $this->call(EnginesTableSeeder::class);
        $this->command->info('Engine table seeded!');
        
        $this->call(ProgramsTableSeeder::class);
        $this->command->info('Program table seeded!');

        $this->call(UsersTableSeeder::class);
        $this->command->info('User table seeded!');
        
        $this->call(TripsTableSeeder::class);
        $this->command->info('Trip table seeded!');
    }
}

class ModesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('modes')->delete();

        Mode::create(['modeType' => 'car']);
        Mode::create(['modeType' => 'carpool']);
        Mode::create(['modeType' => 'public_transport']);
        Mode::create(['modeType' => 'bike']);
        Mode::create(['modeType' => 'walk']);
    }

}

class EnginesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('engines')->delete();

        Engine::create(['engineType' => 'diesel']);
        Engine::create(['engineType' => 'gasoline']);
        Engine::create(['engineType' => 'electric']);
    }

}

class ProgramsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('programs')->delete();

        Program::create(['programType' => 'Accounting and Management Technology']);
        Program::create(['programType' => 'ALC']);
        Program::create(['programType' => 'Arts, Literature and Communication (ALC)']);
        Program::create(['programType' => 'Biomedical Laboratory Technology']);
        Program::create(['programType' => 'Civil Engineering Technology']);
        Program::create(['programType' => 'Computer Science Technology']);
        Program::create(['programType' => 'Developmental Science']);
        Program::create(['programType' => 'Diagnostic Imaging']);
        Program::create(['programType' => 'Electronics Engineering Technology']);
        Program::create(['programType' => 'Explorations Science']);
        Program::create(['programType' => 'Graphic Design']);
        Program::create(['programType' => 'Illustration']);
        Program::create(['programType' => 'Industrial Design']);
        Program::create(['programType' => 'Interactive Media Arts']);
        Program::create(['programType' => 'Interior Design']);
        Program::create(['programType' => 'Laboratory Technology - Analytical Chemistry']);
        Program::create(['programType' => 'Liberal Arts']);
        Program::create(['programType' => 'Marketing and Management Technology']);
        Program::create(['programType' => 'Mechanical Engineering Technology']);
        Program::create(['programType' => 'Nursing']);
        Program::create(['programType' => 'Physiotherapy Technology']);
        Program::create(['programType' => 'Professional Photography']);
        Program::create(['programType' => 'Professional Theatre']);
        Program::create(['programType' => 'Science']);
        Program::create(['programType' => 'Social Science']);
        Program::create(['programType' => 'Social Service']);
        Program::create(['programType' => 'Visual Arts']);
    }

}

class UsersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create([
            'name' => 'name1', 
            'email' => 'q@q.q', 
            'password' => Hash::make('password1'), 
            'home_latitude' =>  45.546529,    
            'home_longitude' => -73.607254, 
            'school_latitude' => 45.489420, 
            'school_longitude' => -73.587280,
            'created_at' => '2019-10-10 10:10:10', 
            'engine_id' => 1, 
            'program_id' => 1,
            'fuel_consumption' => 10,
            ]);
            
         User::create([
            'name' => 'name2', 
            'email' => 'w@w.w', 
            'password' => Hash::make('password2'), 
            'home_latitude' => 45.532691,
            'home_longitude' => -73.648549,
            'school_latitude' => 45.489420, 
            'school_longitude' => -73.587280,
            'created_at' => '2019-10-11 10:10:10', 
            'engine_id' => 2, 
            'program_id' => 2,
            'fuel_consumption' => 15,
            ]);
            
        User::create([
            'name' => 'name3', 
            'email' => 'e@e.e', 
            'password' => Hash::make('password3'), 
            'home_latitude' => 45.526880,
            'home_longitude' => -73.567431,
            'school_latitude' => 45.489420, 
            'school_longitude' => -73.587280,
            'created_at' => '2019-10-12 10:10:10', 
            'engine_id' => 3, 
            'program_id' => 3,
            'fuel_consumption' => 0,
            ]);
    }

}

class TripsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('trips')->delete();

        Trip::create([
            'user_id' => 1, 
            'mode_id'=> 1, 
            'co2emission' => 2.2, 
            'fromlatitude' =>  45.459420,
            'fromlongitude' => -73.557280, 
            'tolatitude' => 45.489420,
            'tolongitude' => -73.587280, 
            'distance' => 7497,
            'traveltime' => 900
        ]);
        Trip::create([
            'user_id' => 1, 
            'mode_id'=> 2, 
            'co2emission' => 1.1, 
            'fromlatitude' =>  45.459420,
            'fromlongitude' => -73.557280, 
            'tolatitude' => 45.489420,
            'tolongitude' => -73.587280, 
            'distance' => 7497,
            'traveltime' => 900
        ]);
        Trip::create([
            'user_id' => 1, 
            'mode_id'=> 3, 
            'co2emission' => 0.71785, 
            'fromlatitude' =>  45.459820,
            'fromlongitude' => -73.558280, 
            'tolatitude' => 45.489420,
            'tolongitude' => -73.587280, 
            'distance' => 15538,
            'traveltime' => 3083
        ]);
        Trip::create([
            'user_id' => 1, 
            'mode_id'=> 4, 
            'co2emission' => 0, 
            'fromlatitude' =>  45.459820,
            'fromlongitude' => -73.558280, 
            'tolatitude' => 45.489420,
            'tolongitude' => -73.587280, 
            'distance' => 18983,
            'traveltime' => 9543
        ]);
        Trip::create([
            'user_id' => 1, 
            'mode_id'=> 5, 
            'co2emission' => 0, 
            'fromlatitude' => 45.459415,
            'fromlongitude' => -73.58767,
            'tolatitude' => 45.489420,
            'tolongitude' => -73.587280,
            'distance' => 4368,
            'traveltime' => 4463
        ]);
        Trip::create([
            'user_id' => 2, 
            'mode_id'=> 1, 
            'co2emission' => 1.392, 
            'fromlatitude' => 45.459417, 
            'fromlongitude' => -73.587201,
            'tolatitude' => 45.489420,
            'tolongitude' => -73.587211,
            'distance' => 5273,
            'traveltime' => 745
        ]);
        Trip::create([
            'user_id' => 2, 
            'mode_id'=> 2, 
            'co2emission' => 0.8065, 
            'fromlatitude' => 45.450417, 
            'fromlongitude' => -73.587201,
            'tolatitude' => 45.489420,
            'tolongitude' => -73.587211,
            'distance' => 6108,
            'traveltime' => 793
        ]);
        Trip::create([
            'user_id' => 2, 
            'mode_id'=> 3, 
            'co2emission' => 0.38503, 
            'fromlatitude' => 45.450417, 
            'fromlongitude' => -73.587201,
            'tolatitude' => 45.489420,
            'tolongitude' => -73.587280,
            'distance' => 8334,
            'traveltime' => 1580
        ]);
        Trip::create([
            'user_id' => 2, 
            'mode_id'=> 4, 
            'co2emission' => 0, 
            'fromlatitude' => 45.450417, 
            'fromlongitude' => -73.587201,
            'tolatitude' => 45.489420,
            'tolongitude' => -73.587211,
            'distance' => 5648,
            'traveltime' => 1641
        ]);
        Trip::create([
            'user_id' => 2, 
            'mode_id'=> 5, 
            'co2emission' => 0, 
            'fromlatitude' => 45.450617, 
            'fromlongitude' => -73.587301,
            'tolatitude' => 45.489420,
            'tolongitude' => -73.587211,
            'distance' => 5482,
            'traveltime' => 5586
        ]);
        Trip::create([
            'user_id' => 3, 
            'mode_id'=> 4, 
            'co2emission' => 0, 
            'fromlatitude' => 45.459419, 
            'fromlongitude' => -73.587211,
            'tolatitude' => 45.489420,
            'tolongitude' => -73.587280,
            'distance' => 3000,
            'traveltime' => 13890
        ]);
    }
}
