<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Asset;
use ReturnTypeWillChange;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class AssetPolicy
{
    protected $sharedAssets;
    public function __construct()
    {
        $this->sharedAssets = Asset::with('users')->whereHas('users')->get();
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Asset $asset): bool
    {

        if ($this->sharedAssets) {
            return true;
        } else {
            return $user->id === $asset->user_id;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Asset $asset): bool
    {
        return $user->id === $asset->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Asset $asset): bool
    {
        return $user->id === $asset->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Asset $asset): bool
    {
        return $user->id === $asset->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Asset $asset): bool
    {
        return $user->id === $asset->user_id;
    }
}
