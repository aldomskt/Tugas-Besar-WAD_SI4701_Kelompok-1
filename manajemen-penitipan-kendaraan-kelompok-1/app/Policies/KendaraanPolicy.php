<?php

namespace App\Policies;

use App\Models\Kendaraan;
use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Auth\Access\Response;

class KendaraanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Pelanggan $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Pelanggan $user, Kendaraan $kendaraan): bool
    {
        return $user->id === $kendaraan->pelanggan_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Pelanggan $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Pelanggan $user, Kendaraan $kendaraan): bool
    {
        return $user->id === $kendaraan->pelanggan_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Pelanggan $user, Kendaraan $kendaraan): bool
    {
        return $user->id === $kendaraan->pelanggan_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Pelanggan $user, Kendaraan $kendaraan): bool
    {
        return $user->id === $kendaraan->pelanggan_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Pelanggan $user, Kendaraan $kendaraan): bool
    {
        return $user->id === $kendaraan->pelanggan_id;
    }
}
