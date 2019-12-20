<?php

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
        $this->TruncateTables([
            'Rol',
            'Permiso'
        ]);
        $this->call(RolSeeder::class);
        $this->call(PermisoSeeder::class);
    }
    protected function TruncateTables(array $tables)
    {
        foreach ($tables as $table){
            DB::table($table)->delete();
            if ($table == 'Rol' || $table == 'Permiso'){
                DB::statement('DBCC CHECKIDENT ('.$table.', RESEED, 0)');
            }
        }
    }
}
