<?php

namespace App\Policies;

use App\Models\Layanan;
use App\Models\Penjaga;
use Illuminate\Auth\Access\HandlesAuthorization;

class LayananPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the penjaga can view any models.
     */
    public function viewAny(Penjaga $penjaga): bool
    {
        return true;
    }

    /**
     * Determine whether the penjaga can view the model.
     */
    public function view(Penjaga $penjaga, Layanan $layanan): bool
    {
        return $penjaga->id === $layanan->penjaga_id;
    }

    /**
     * Determine whether the penjaga can create models.
     */
    public function create(Penjaga $penjaga): bool
    {
        return true;
    }

    /**
     * Determine whether the penjaga can update the model.
     */
    public function update(Penjaga $penjaga, Layanan $layanan): bool
    {
        return $penjaga->id === $layanan->penjaga_id;
    }

    /**
     * Determine whether the penjaga can delete the model.
     */
    public function delete(Penjaga $penjaga, Layanan $layanan): bool
    {
        return $penjaga->id === $layanan->penjaga_id;
    }
} 