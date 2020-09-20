<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\CastMember;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidations;

class CastMemberControllerTest extends TestCase
{
    use DatabaseMigrations, TestValidations, TestSaves;

    private $castMember;
    protected function setUp(): void
    {
        parent::setUp();
        $this->castMember = factory(CastMember::class)->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('api.cast_members.index'));

        $response
            ->assertStatus(200)
            ->assertJson([$this->castMember->toArray()]);
    }

    public function testShow()
    {
        $response = $this->get(route('api.cast_members.show', ['cast_member' => $this->castMember->id]));

        $response
            ->assertStatus(200)
            ->assertJson($this->castMember->toArray());
    }

    public function testInvalitationData()
    {
        $data = [
            'name' => '',
            'type' => ''
        ];
        $this->assertInvalidationInStoreAction($data, 'required');
        $this->assertInvalidationInUpdateAction($data, 'required');
      
        $data = [
            'type' => 's'
        ];
        $this->assertInvalidationInStoreAction($data, 'in');
        $this->assertInvalidationInUpdateAction($data, 'in');
    }

    public function testStore()
    {
        $data =[
            [
                'name' => 'test',
                'type' => CastMember::TYPE_DIRECTOR
            ],
            [
                'name' => 'test',
                'type' => CastMember::TYPE_ACTOR
            ]
        ];

        foreach ($data as $key => $value) {
            $response = $this->assertStore($value, $value + ['deleted_at' => null]);
            $response->assertJsonStructure([
                'created_at', 'updated_at'
            ]);
        }
    }

    public function testUpdate()
    {
        $data =  [
            'name' => 'test',
            'type' => CastMember::TYPE_ACTOR       
        ];

        $response = $this->assertUpdate($data, $data + ['deleted_at' => null]);
        $response->assertJsonStructure([
            'created_at', 
            'updated_at'
        ]);
    }

    public function testDestroy()
    {
        $response = $this->json('DELETE', $this->routeDelete());
        $response
            ->assertStatus(204);
        $this->assertNull(CastMember::find($this->castMember->id));
        $this->assertNotNull(CastMember::withTrashed()->find($this->castMember->id)); 
    }

    protected function routeStore()
    {
        return route('api.cast_members.store');
    }

    protected function routeUpdate()
    {
        return route('api.cast_members.update', ['cast_member' => $this->castMember->id]);
    }

    protected function routeDelete()
    {
        return route('api.cast_members.destroy', ['cast_member' => $this->castMember->id]);
    }

    protected function model()
    {
        return CastMember::class;
    }
}
