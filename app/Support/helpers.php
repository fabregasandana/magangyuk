<?php

use App\Models\User;

if (! function_exists('dashboardRoute')) {
    /**
     * Nama route dashboard sesuai role user.
     */
    function dashboardRoute(?string $role): string
    {
        return match ($role) {
            User::ROLE_ADMIN => 'admin.dashboard',
            User::ROLE_PEMBIMBING => 'pembimbing.dashboard',
            default => 'peserta.dashboard',
        };
    }
}

if (! function_exists('dashboardPath')) {
    /**
     * Path dashboard sesuai role (dipakai redirect()->intended()).
     */
    function dashboardPath(?string $role): string
    {
        return match ($role) {
            User::ROLE_ADMIN => '/admin',
            User::ROLE_PEMBIMBING => '/dashboardpembimbing',
            default => '/dashboard',
        };
    }
}
