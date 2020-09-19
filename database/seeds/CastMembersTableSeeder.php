<?php

use App\Models\CastMember;
use Illuminate\database\Seeder;

class CastMembersTableSeeder extends Seeder
{
    public function run()
    {
        factory(CastMember::class, 100)->create();
    }
}
