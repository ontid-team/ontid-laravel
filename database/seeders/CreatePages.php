<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreatePages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = ['Terms & Conditions', 'Privacy policy', 'About us', 'For business owners', 'For customer', 'Contact us'];
        foreach ($pages as $page) {
            $model = new Page();
            $model->name = $page;
            $model->save();
        }
    }

}
