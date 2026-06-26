<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\PaymentRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ClientBillingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_client_can_see_their_own_payment_requests(): void
    {
        Carbon::setTestNow('2026-06-26 10:00:00');

        $client = Client::factory()->create();
        $user = User::factory()->for($client)->create();
        $project = Project::factory()->for($client)->create(['title' => 'Client Website Refresh']);

        PaymentRequest::factory()->for($client)->for($project)->create([
            'title' => 'Website deposit',
            'amount' => 125000,
            'status' => 'sent',
            'due_date' => '2026-07-10',
        ]);

        $this->actingAs($user)
            ->get(route('client.billing.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Client/Billing/Index')
                ->has('outstandingPayments', 1)
                ->where('outstandingPayments.0.title', 'Website deposit')
                ->where('outstandingPayments.0.project_name', 'Client Website Refresh')
                ->where('outstandingPayments.0.amount', '£1,250.00')
                ->where('outstandingPayments.0.status', 'sent')
                ->where('outstandingPayments.0.status_label', 'Sent')
                ->where('outstandingPayments.0.due_date', 'Jul 10, 2026')
                ->where('outstandingPayments.0.can_pay', true)
                ->has('paidPayments', 0)
            );

        Carbon::setTestNow();
    }

    public function test_client_cannot_see_another_clients_payment_requests(): void
    {
        $client = Client::factory()->create();
        $otherClient = Client::factory()->create();
        $user = User::factory()->for($client)->create();
        $project = Project::factory()->for($client)->create();
        $otherProject = Project::factory()->for($otherClient)->create();

        PaymentRequest::factory()->for($client)->for($project)->create([
            'title' => 'Owned payment request',
            'status' => 'sent',
        ]);
        PaymentRequest::factory()->for($otherClient)->for($otherProject)->create([
            'title' => 'Private other payment request',
            'status' => 'sent',
        ]);

        $this->actingAs($user)
            ->get(route('client.billing.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->has('outstandingPayments', 1)
                ->where('outstandingPayments.0.title', 'Owned payment request')
                ->has('paidPayments', 0)
            )
            ->assertDontSee('Private other payment request');
    }

    public function test_paid_and_outstanding_requests_are_grouped_correctly(): void
    {
        $client = Client::factory()->create();
        $user = User::factory()->for($client)->create();
        $project = Project::factory()->for($client)->create();

        PaymentRequest::factory()->for($client)->for($project)->create([
            'title' => 'Draft request',
            'status' => 'draft',
        ]);
        PaymentRequest::factory()->for($client)->for($project)->create([
            'title' => 'Sent request',
            'status' => 'sent',
        ]);
        PaymentRequest::factory()->for($client)->for($project)->create([
            'title' => 'Paid request',
            'status' => 'paid',
            'paid_at' => '2026-06-25 12:00:00',
        ]);

        $this->actingAs($user)
            ->get(route('client.billing.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->has('outstandingPayments', 2)
                ->where('outstandingPayments.0.title', 'Sent request')
                ->where('outstandingPayments.0.can_pay', true)
                ->where('outstandingPayments.1.title', 'Draft request')
                ->where('outstandingPayments.1.can_pay', false)
                ->has('paidPayments', 1)
                ->where('paidPayments.0.title', 'Paid request')
                ->where('paidPayments.0.paid_date', 'Jun 25, 2026')
            );
    }

    public function test_unauthenticated_users_are_redirected_to_login(): void
    {
        $this->get(route('client.billing.index'))
            ->assertRedirect(route('login'));
    }
}
