<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {

        DB::table('companies')->insert([
            'company_name'    => 'Intertest',
            'company_details' => 'We are a leading company committed to delivering high-quality products and services.
                Our mission is to innovate, inspire, and impact the lives of our customers and communities.',
            'email'           => 'company@gmail.com',
            'phone'           => '01500000000',
            'address'         => 'Dhaka, Bangladesh',
            'status'          => 1,
            'created_at'      => now(),
            'created_by'      => 1,
            'updated_at'      => now(),
            'updated_by'      => 1,
        ]);

        DB::table('users')->insert([
            'role'       => 1,
            'is_admin'   => 1,
            'name'       => 'Super Admin',
            'email'      => 'admin@gmail.com',
            'phone'       => '01500000000',
            'password'   => bcrypt('123456'),
            'address'    => 'Dhaka, Bangladesh',
            'created_at' => now(),
            'created_by' => 1,
            'updated_at' => now(),
            'updated_by' => 1,
        ]);

        DB::table('users')->insert([
            'role'       => 0,
            'is_admin'   => 0,
            'name'       => 'Customer',
            'email'      => 'customer@gmail.com',
            'phone'       => '01700000000',
            'password'   => bcrypt('123456'),
            'address'    => 'Dhaka, Bangladesh',
            'created_at' => now(),
            'created_by' => 1,
            'updated_at' => now(),
            'updated_by' => 1,
        ]);

        DB::table('customers')->insert([
            'customer_id' => 'CID000',
            'name'        => 'Customer',
            'email'       => 'customer@gmail.com',
            'phone'       => '01700000000',
            'password'    => bcrypt('123456'),
            'address'     => 'Dhaka, Bangladesh',
            'created_at'  => now(),
            'created_by'  => 1,
            'updated_at'  => now(),
            'updated_by'  => 1,
        ]);

    }
}
