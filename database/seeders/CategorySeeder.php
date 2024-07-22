<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::updateOrCreate([
            'name'=>'Work',
        ],[
            'name'=>'Work',
        ]);
    
    
        Category::updateOrCreate([
            'name'=>'Personal',
        ],[
            'name'=>'Personal',
        ]);
        Category::updateOrCreate([
            'name'=>'Urgent',
        ],[
            'name'=>'Urgent',
        ]);
    
    
    }
}
