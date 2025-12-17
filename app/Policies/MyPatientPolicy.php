<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MyPatient;
use Illuminate\Auth\Access\HandlesAuthorization;

class MyPatientPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MyPatient');
    }

    public function view(AuthUser $authUser, MyPatient $myPatient): bool
    {
        return $authUser->can('View:MyPatient');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MyPatient');
    }

    public function update(AuthUser $authUser, MyPatient $myPatient): bool
    {
        return $authUser->can('Update:MyPatient');
    }

    public function delete(AuthUser $authUser, MyPatient $myPatient): bool
    {
        return $authUser->can('Delete:MyPatient');
    }

    public function restore(AuthUser $authUser, MyPatient $myPatient): bool
    {
        return $authUser->can('Restore:MyPatient');
    }

    public function forceDelete(AuthUser $authUser, MyPatient $myPatient): bool
    {
        return $authUser->can('ForceDelete:MyPatient');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MyPatient');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MyPatient');
    }

    public function replicate(AuthUser $authUser, MyPatient $myPatient): bool
    {
        return $authUser->can('Replicate:MyPatient');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MyPatient');
    }

}