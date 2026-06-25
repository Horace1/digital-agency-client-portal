<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SupportTicket>
 */
class SupportTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(array_keys(SupportTicket::statuses()));

        return [
            'project_id' => Project::factory(),
            'created_by' => User::factory(),
            'title' => fake()->sentence(5),
            'description' => fake()->paragraphs(2, true),
            'status' => $status,
            'priority' => fake()->randomElement(['low', 'medium', 'high', 'urgent']),
            'due_date' => fake()->optional(0.6)->dateTimeBetween('now', '+1 month'),
            'completed_at' => in_array($status, [SupportTicket::STATUS_RESOLVED, SupportTicket::STATUS_CLOSED], true)
                ? fake()->dateTimeBetween('-1 month', 'now')
                : null,
        ];
    }
}
