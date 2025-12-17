<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MySchedule;
use Illuminate\Auth\Access\HandlesAuthorization;

class MySchedulePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MySchedule');
    }

    public function view(AuthUser $authUser, MySchedule $mySchedule): bool
    {
        return $authUser->can('View:MySchedule');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MySchedule');
    }

    public function update(AuthUser $authUser, MySchedule $mySchedule): bool
    {
        return $authUser->can('Update:MySchedule');
    }

    public function delete(AuthUser $authUser, MySchedule $mySchedule): bool
    {
        return $authUser->can('Delete:MySchedule');
    }

    public function restore(AuthUser $authUser, MySchedule $mySchedule): bool
    {
        return $authUser->can('Restore:MySchedule');
    }

    public function forceDelete(AuthUser $authUser, MySchedule $mySchedule): bool
    {
        return $authUser->can('ForceDelete:MySchedule');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MySchedule');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MySchedule');
    }

    public function replicate(AuthUser $authUser, MySchedule $mySchedule): bool
    {
        return $authUser->can('Replicate:MySchedule');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MySchedule');
    }

}