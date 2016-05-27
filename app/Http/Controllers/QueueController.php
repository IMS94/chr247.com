<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Patient;
use App\Queue;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QueueController extends Controller {
    /**
     * View the page consisting of the queue
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewQueue() {
        return view('queue.queue', ['queue' => Queue::getCurrentQueue()]);
    }


    /**
     * Adds a patient to the queue
     * @param $patientId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToQueue($patientId) {
        $patient = Patient::find($patientId);
        $queue = Queue::getCurrentQueue();
        if (empty($queue)) {
            return back()->with('error', 'Please start a new queue in order to add patients.');
        }

        //check if user has permissions to add patients to queues
        $this->authorize('addToQueue', $patient);

        //check if the user can add patients to the current queue
        $this->authorize('addPatient', $queue);

        if ($queue->patients()->where('patients.id', $patientId)->count() > 0) {
            return back()->with('error', 'Patient is already in the queue');
        }
        $queue->patients()->attach($patient, ['inProgress' => false]);
        return redirect()->route('queue')->with('success', 'Patient successfully added to the queue!');
    }

    /**
     * Creates a new Queue
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createQueue() {
        $currentQueue = Queue::getCurrentQueue();
        $this->authorize('create', 'App\Queue');

        DB::beginTransaction();
        try {
            if (!is_null($currentQueue)) {
                $currentQueue->active = false;
                $currentQueue->update();
            }
            $queue = new Queue();
            $queue->date = date('Y-m-d');
            $queue->creator()->associate(User::getCurrentUser());
            $queue->clinic()->associate(Clinic::getCurrentClinic());
            $queue->save();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Could not create a new Queue');
        }
        DB::commit();
        return back()->with('success', 'New Queue created!');
    }

    /**
     * Close the current Queue
     * @return \Illuminate\Http\RedirectResponse
     */
    public function closeQueue() {
        $currentQueue = Queue::getCurrentQueue();
        $this->authorize('close', $currentQueue);

        DB::beginTransaction();
        try {
            $currentQueue->active = false;
            $currentQueue->update();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Could not close the current queue');
        }
        DB::commit();
        return back()->with('success', 'Queue closed!');
    }
}
