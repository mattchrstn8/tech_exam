<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create task');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        // Admin and manager can update any, user can update own
        if ($user->hasRole('admin') || $user->hasRole('manager')) {
            return $user->can('manage tasks') || $user->can('manage all tasks');
        }
        return $user->can('create task') && $user->id === $task->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        // Admin can delete any, manager can delete any, user can delete own
        if ($user->hasRole('admin') || $user->hasRole('manager')) {
            return $user->can('delete task');
        }
        return $user->can('delete task') && $user->id === $task->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return false;
    }

    public function assign(User $user, Task $task): bool
    {
        // Only users with assign task permission can assign
        return $user->can('assign task');
    }
}
