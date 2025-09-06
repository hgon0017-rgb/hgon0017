<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $avatar
 * @property string|null $role         // 'customer' | 'admin'
 * @property string|null $nonce
 * @property \Cake\I18n\FrozenTime|null $nonce_expiry
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property string $user_full_display  (virtual)
 * @property string $full_name          (virtual)
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned via newEntity() or patchEntity().
     *
     * Notes:
     * - "created" and "modified" are automatically handled by the Timestamp behavior, keep them false.
     * - Fields that should be editable via forms: email, password, role, nonce, nonce_expiry,
     *   first_name, last_name, avatar → true
     */
    protected array $_accessible = [
        'email'         => true,
        'password'      => true,
        'first_name'    => true,
        'last_name'     => true,
        'avatar'        => true,
        'role'          => true,   // ✅ allow role assignment in forms
        'nonce'         => true,   // ✅ allow write
        'nonce_expiry'  => true,   // ✅ allow write (datetime-local from form)
        'created'       => false,  // handled by behavior
        'modified'      => false,  // handled by behavior
        'blog_articles' => true,   // can be removed if no association exists
    ];

    /**
     * Fields excluded from JSON and array outputs.
     */
    protected array $_hidden = [
        'password',
    ];

    /**
     * Virtual fields (optional, but clearer to declare if getters exist).
     */
    protected array $_virtual = [
        'user_full_display',
        'full_name',
    ];

    /**
     * Virtual field: display-friendly full identity (name + email).
     */
    protected function _getUserFullDisplay(): string
    {
        $first = $this->first_name ?? '';
        $last  = $this->last_name ?? '';
        $name  = trim($first . ' ' . $last);
        return ($name !== '' ? $name : $this->email) . ' (' . $this->email . ')';
    }

    /**
     * Virtual field: full name (first + last).
     */
    protected function _getFullName(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }

    /**
     * Automatically hash the password when it is set.
     *
     * - If a non-empty password is provided, hash it before saving.
     * - If password is empty, keep the original (useful in edit forms when password is not changed).
     */
    protected function _setPassword(string $password): ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
        // Keep original value when empty (edit form does not change password)
        return $password;
    }
}
