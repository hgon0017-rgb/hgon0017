<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Products;
use Authorization\IdentityInterface;

/**
 * Products policy
 */
class ProductsPolicy
{
    /**
     * Check if $user can add Products
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Products $products
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Products $products)
    {
    }

    /**
     * Check if $user can edit Products
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Products $products
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Products $products)
    {
    }

    /**
     * Check if $user can delete Products
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Products $products
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Products $products)
    {
    }

    /**
     * Check if $user can view Products
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Products $products
     * @return bool
     */
    public function canView(IdentityInterface $user, Products $products)
    {
    }
}
