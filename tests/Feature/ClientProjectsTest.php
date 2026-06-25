<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ClientProjectsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_client_can_only_see_their_projects_on_the_index(): void
    {
        $client = Client::factory()->create();
        $otherClient = Client::factory()->create();
        $user = User::factory()->create(['client_id' => $client->id]);
        $project = Project::factory()->for($client)->create(['title' => 'Client Website Refresh']);
        $otherProject = Project::factory()->for($otherClient)->create(['title' => 'Private Internal Build']);

        $response = $this->actingAs($user)->get(route('client.projects.index'));

        $response
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Client/Projects/Index')
                ->has('projects.data', 1)
                ->where('projects.data.0.title', $project->title)
            )
            ->assertDontSee($otherProject->title);
    }

    public function test_client_can_view_project_details_for_their_client_record(): void
    {
        $client = Client::factory()->create();
        $user = User::factory()->create(['client_id' => $client->id]);
        $project = Project::factory()->for($client)->create([
            'title' => 'Client Portal Launch',
            'status' => 'in_progress',
        ]);

        $response = $this->actingAs($user)->get(route('client.projects.show', $project));

        $response
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Client/Projects/Show')
                ->where('project.title', 'Client Portal Launch')
                ->where('project.status_label', 'In Progress')
                ->where('project.progress_percentage', 50)
            );
    }

    public function test_client_cannot_view_another_clients_project(): void
    {
        $client = Client::factory()->create();
        $otherClient = Client::factory()->create();
        $user = User::factory()->create(['client_id' => $client->id]);
        $otherProject = Project::factory()->for($otherClient)->create();

        $this->actingAs($user)
            ->get(route('client.projects.show', $otherProject))
            ->assertForbidden();
    }
}
