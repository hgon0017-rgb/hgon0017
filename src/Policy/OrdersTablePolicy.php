<?php
declare(strict_types=1);

namespace App\Policy;

use Authorization\IdentityInterface;
use Cake\ORM\Query;

class OrdersTablePolicy
{
    /**
     * Scope for index queries (who can see what orders in index).
     */
    public function scopeIndex(IdentityInterface $user, Query $query)
    {
        if ($user->get('role') === 'admin') {
            return $query; // Admins see all orders
        }

        if ($user->get('role') === 'customer') {
            return $query->where(['Orders.user_id' => $user->getIdentifier()]);
        }

        return $query->where(['1 = 0']); // deny everyone else
    }

    /**
     * Gate to allow index action (applies before scope is used).
     */
    public function canIndex(IdentityInterface $user): bool
    {
        return in_array($user->get('role'), ['admin', 'customer'], true);
    }
}
