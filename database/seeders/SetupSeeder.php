<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        DB::table('users')->insert([
            'name' => 'Sakib Islam Uzzal',
            'phone' =>'01738875236',
            'email' => 'shakib1231241254@gmail.com',
            'username' =>'sakibbd',
            'role' => 1,
            'slug' =>'U'.uniqid(20),
            'created_at' =>Carbon::now('asia/dhaka')->toDateTimeString(),
            'password' => Hash::make('12345678'),
        ]);

        DB::table('basics')->insert([
            'basic_company' => 'Creative System Limited',
            'basic_title' =>'Software Company',
            'basic_creator' => 1,
            'basic_slug' =>'B'.uniqid(20),
            'created_at' =>Carbon::now('asia/dhaka')->toDateTimeString(),
        ]);

        DB::table('social_media')->insert([
            'sm_facebook' => 'www.facebook.com',
            'sm_twitter' =>'#',
            'sm_slug' =>'Sm'.uniqid(20),
            'sm_creator' => 1,
            'created_at' =>Carbon::now('asia/dhaka')->toDateTimeString(),
        ]);

        DB::table('contact_information')->insert([
            'ci_phone1' => '01738875235',
            'ci_email1' =>'tamimm@gmail.com',
            'ci_address1' => 'Dhanmondi Dhaka',
            'ci_slug' =>'CI'.uniqid(20),
            'ci_creator' => 1,
            'created_at' =>Carbon::now('asia/dhaka')->toDateTimeString(),
        ]);

        $roles=['Sudperadmin','Admin','Author','Editor','Subscriber'];
        foreach($roles as $urole){
            DB::table('roles')->insert([
                'role_name' => $urole,
                'role_slug' => 'R'.uniqid(20),
                'created_at' => Carbon::now('asia/dhaka')->toDateTimeString(),
            ]);
        }
    }
}
