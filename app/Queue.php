<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $table = "queues";

    /**
     * User's clinic
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clinic()
    {
        return $this->belongsTo('App\Clinic', 'clinic_id', 'id');
    }

    /**
     * Get the patients of this queue
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patients()
    {
        return $this->belongsToMany('App\Patient', 'queue_patients', 'queue_id', 'patient_id')->withTimestamps();
    }

    /**
     * Get the user who created the queue
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }


    /**
     * Get the current queue of the clinic
     * @return null
     */
    public static function getCurrentQueue()
    {
        $clinic = Clinic::getCurrentClinic();
        $queue = $clinic->queues()->orderBy('id', 'desc')->first();
        if (empty($queue) || !$queue->active) {
            return null;
        }
        return $queue;
    }
}
