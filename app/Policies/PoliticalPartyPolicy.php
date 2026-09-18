<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PoliticalParty;
use Illuminate\Auth\Access\HandlesAuthorization;

class PoliticalPartyPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PoliticalParty');
    }

    public function view(AuthUser $authUser, PoliticalParty $politicalParty): bool
    {
        return $authUser->can('View:PoliticalParty');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PoliticalParty');
    }

    public function update(AuthUser $authUser, PoliticalParty $politicalParty): bool
    {
        return $authUser->can('Update:PoliticalParty');
    }

    public function delete(AuthUser $authUser, PoliticalParty $politicalParty): bool
    {
        return $authUser->can('Delete:PoliticalParty');
    }

    public function restore(AuthUser $authUser, PoliticalParty $politicalParty): bool
    {
        return $authUser->can('Restore:PoliticalParty');
    }

    public function forceDelete(AuthUser $authUser, PoliticalParty $politicalParty): bool
    {
        return $authUser->can('ForceDelete:PoliticalParty');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PoliticalParty');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PoliticalParty');
    }

    public function replicate(AuthUser $authUser, PoliticalParty $politicalParty): bool
    {
        return $authUser->can('Replicate:PoliticalParty');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PoliticalParty');
    }

}