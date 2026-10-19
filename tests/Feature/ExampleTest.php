<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_opens(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Student Record Application');
    }

    public function test_student_is_saved(): void
    {
        $this->post('/students', [
            'name' => 'Ahmer Abbas',
            'email' => 'ahmer@example.com',
            'course' => 'Cloud Computing',
        ])->assertRedirect('/');

        $this->assertDatabaseHas('students', [
            'email' => 'ahmer@example.com',
        ]);
    }

    public function test_invalid_student_is_rejected(): void
    {
        $this->post('/students', [
            'name' => '',
            'email' => 'invalid',
            'course' => '',
        ])->assertSessionHasErrors(['name', 'email', 'course']);

        $this->assertDatabaseCount('students', 0);
    }
}
