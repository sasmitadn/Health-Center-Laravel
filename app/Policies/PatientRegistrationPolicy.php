<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PatientRegistration;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientRegistrationPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PatientRegistration');
    }

    public function view(AuthUser $authUser, PatientRegistration $patientRegistration): bool
    {
        return $authUser->can('View:PatientRegistration');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PatientRegistration');
    }

    public function update(AuthUser $authUser, PatientRegistration $patientRegistration): bool
    {
        return $authUser->can('Update:PatientRegistration');
    }

    public function delete(AuthUser $authUser, PatientRegistration $patientRegistration): bool
    {
        return $authUser->can('Delete:PatientRegistration');
    }

    public function restore(AuthUser $authUser, PatientRegistration $patientRegistration): bool
    {
        return $authUser->can('Restore:PatientRegistration');
    }

    public function forceDelete(AuthUser $authUser, PatientRegistration $patientRegistration): bool
    {
        return $authUser->can('ForceDelete:PatientRegistration');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PatientRegistration');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PatientRegistration');
    }

    public function replicate(AuthUser $authUser, PatientRegistration $patientRegistration): bool
    {
        return $authUser->can('Replicate:PatientRegistration');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PatientRegistration');
    }

}