<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Queue;

class QueuePolicy
{
    public function update(User $user, Queue $queue)
    {
        return $user->id_pengguna === $queue->patient->id_pengguna;
    }

    public function delete(User $user, Queue $queue)
    {
        return $user->id_pengguna === $queue->patient->id_pengguna;
    }
}