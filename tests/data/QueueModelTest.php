<?php
namespace Tests\Data;

use App\Queue;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class QueueModelTest extends \Tests\TestCase {

    public function testCreateAndDeleteQueue() {
        $user = User::first();
        $queue = new Queue();
        $queue->creator()->associate($user);
        $queue->clinic()->associate($user->clinic);
        $queue->save();
        $this->seeInDatabase('queues', ['id' => $queue->id]);

        $patients = $user->clinic->patients()->take(5)->get();
        $queue->patients()->attach($patients);
        $this->seeInDatabase('queue_patients', ['queue_id' => $queue->id, 'patient_id' => $patients[0]->id]);

        try {
            $queue->delete();
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof \PDOException);
        }

        $queue->patients()->delete();
        $queue->delete();
        $this->dontSeeInDatabase('queues', ['id' => $queue->id]);
        $this->dontSeeInDatabase('queue_patients', ['queue_id' => $queue->id, 'patient_id' => $patients[0]->id]);
    }
}
