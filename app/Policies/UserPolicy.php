<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAuditLogs(User $user): bool
    {
        return $user->canViewAuditTrail();
    }
}
