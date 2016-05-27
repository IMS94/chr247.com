<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class QueueTest extends TestCase {

    use DatabaseTransactions;

    /**
     * test creating a new queue, success and fail
     */
    public function testAllQueueFunctions() {
        $user = \App\User::where('role_id', 1)->first();
        $patient = $user->clinic->patients()->first();
        $this->actingAs($user)
            ->visit('queue')
            ->see('Queue');

        // Create Queue
        $this->actingAs($user)
            ->call('GET', 'queue/create');
        $this->assertSessionHas('success');
        $this->seeInDatabase('queues', [
            'clinic_id'  => $user->clinic->id,
            'created_by' => $user->id,
            'date'       => date('Y-m-d')
        ]);

        $queue = \App\Queue::getCurrentQueue();
        // Add patient to queue
        $this->actingAs($user)
            ->call('GET', 'queue/addToQueue/' . $patient->id);
        $this->assertSessionHas('success');
        $this->seeInDatabase('queue_patients', ['patient_id' => $patient->id, 'queue_id' => $queue->id]);

        // Get Queue
        $this->actingAs($user)
            ->json('POST', 'API/getQueue')
            ->seeJson(['status' => 1]);

        // Update Queue
        $this->actingAs($user)
            ->json('POST', 'API/updateQueue', [
                'patient' => [
                    'id'    => $patient->id,
                    'pivot' => [
                        'inProgress' => 2
                    ]
                ]
            ])
            ->seeJson(['status' => 1]);

        // Close queue
        $this->actingAs($user)
            ->call('GET', 'queue/close');
        $this->assertSessionHas('success');

        // delete queue from the database.
        $queue->delete();
        $this->dontSeeInDatabase('queues', ['id' => $queue->id]);
    }
}
