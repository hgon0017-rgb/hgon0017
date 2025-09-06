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
     * 可批量赋值字段（表单可写）
     *
     * 说明：
     * - created / modified 由 Timestamp 行为自动维护，保持 false
     * - 你需要在表单里保存的字段：email / password / role / nonce / nonce_expiry / first_name / last_name / avatar -> true
     */
    protected array $_accessible = [
        'email'         => true,
        'password'      => true,
        'first_name'    => true,
        'last_name'     => true,
        'avatar'        => true,
        'role'          => true,   // ✅ 允许表单写入 role
        'nonce'         => true,   // ✅ 允许写入
        'nonce_expiry'  => true,   // ✅ 允许写入（表单 datetime-local）
        'created'       => false,  // 由行为维护
        'modified'      => false,  // 由行为维护
        'blog_articles' => true,   // 如无此关联可去掉
    ];

    /**
     * 从 JSON / toArray 中隐藏的字段
     */
    protected array $_hidden = [
        'password',
    ];

    /**
     * 虚拟字段（可选，但有 getter 时声明更直观）
     */
    protected array $_virtual = [
        'user_full_display',
        'full_name',
    ];

    /**
     * 显示用完整信息（虚拟字段）
     */
    protected function _getUserFullDisplay(): string
    {
        $first = $this->first_name ?? '';
        $last  = $this->last_name ?? '';
        $name  = trim($first . ' ' . $last);
        return ($name !== '' ? $name : $this->email) . ' (' . $this->email . ')';
    }

    /**
     * 用户全名（虚拟字段）
     */
    protected function _getFullName(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }

    /**
     * 密码自动哈希
     */
    protected function _setPassword(string $password): ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
        // 空字符串时保留原值（edit 不改密码）
        return $password;
    }
}
