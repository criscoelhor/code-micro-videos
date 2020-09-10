<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    public function testFillableAttribute()
    {
        $category = new Category();
        $this->assertEquals(
            ['name','description','is_active'],
            $category->getFillable());
    }

    public function testIfUseTraitsAttribute()
    {
        $traits = [
            SoftDeletes::class, Uuid::class
        ];
        $categoryTraits = array_keys(class_uses(Category::class));
        $this->assertEquals($traits, $categoryTraits);
        //print_r(class_uses(Category::class));
    }

    public function testCatsAttribute()
    {
        $casts = ['id' => 'string'];
        $category = new Category();
        $this->assertEquals($casts,$category->getCasts());
    }

    public function testIncrementingAttribute()
    {
        $category = new Category();
        $this->assertFalse($category->incrementing);
    }
}
