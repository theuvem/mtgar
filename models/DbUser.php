<?php

namespace app\models;

use app\core\DbModel;

class DbUser extends DbModel {

    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;
    public const STATUS_DELETED = 2;

    public int $status = self::STATUS_INACTIVE;

    public string $username = '';
    public string $password = '';
    public string $passwordConfirm = '';
    public string $email = '';
    public string $emailConfirm = '';

    public ?int $id;
    public ?bool $admin;
    public ?string $created_at;

    public static function tableName(): string {
        return 'users';
    }

    public static function columnNames(): array {
        return ['username', 'password', 'email', 'status'];
    }

    public static function primaryKey(): string {
        return 'id';
    }

    public static function getDisplayValue(string $column, $value): string {
        if ($column === 'status') {
            $value = intval($value);

            switch ($value) {
                case self::STATUS_INACTIVE:
                    return 'Inactive';
                case self::STATUS_ACTIVE:
                    return 'Active';
                case self::STATUS_DELETED:
                    return 'Deleted';
            }
        }

        return strval($value);
    }

    public function labels(): array {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'passwordConfirm' => 'Confirm password',
            'email' => 'E-mail address',
            'emailConfirm' => 'Confirm e-mail address'
        ];
    }

    public function rules(): array {
        return [
            'username' => [
                self::RULE_REQUIRED,
                [
                    self::RULE_PATTERN,
                    'pattern' => '/[a-zA-Z0-9]{4,16}/',
                    'description' => 'a name between 4&ndash;16 characters long, only consisting of alphabetical and/or numerical characters'
                ],
                [self::RULE_UNIQUE, 'class' => self::class]
            ],
            'password' => [
                self::RULE_REQUIRED,
                [self::RULE_MIN, 'min' => 8],
                [self::RULE_MAX, 'max' => 255]
            ],
            'passwordConfirm' => [
                self::RULE_REQUIRED,
                [self::RULE_MATCH, 'match' => 'password']
            ],
            'email' => [
                self::RULE_REQUIRED,
                self::RULE_EMAIL,
                [self::RULE_MAX, 'max' => 255],
                [self::RULE_UNIQUE, 'class' => self::class]
            ],
            'emailConfirm' => [
                self::RULE_REQUIRED,
                [self::RULE_MATCH, 'match' => 'email']
            ]
        ];
    }

    public function save(): bool {
        if ($this->deleteInactives()) {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);

            return parent::save();
        }
        
        return false;
    }

    public function delete(): bool {
        $this->status = self::STATUS_DELETED;

        return parent::update(['status']);
    }

    public function deleteInactives(array $columns = ['email', 'username']): bool {
        if (in_array('email', $columns, true)) {
            $inactiveUserWithEmail = self::findObject([
                'email' => ['value' => $this->email],
                'status' => ['value' => self::STATUS_INACTIVE]
            ]);

            if (!empty($inactiveUserWithEmail)) {
                if (!$inactiveUserWithEmail->delete()) {
                    return false;
                }
            }
        }

        if (in_array('username', $columns, true)) {
            $inactiveUserWithName = self::findObject([
                'username' => ['value' => $this->username],
                'status' => ['value' => self::STATUS_INACTIVE]
            ]);

            if (!empty($inactiveUserWithName)) {
                if (!$inactiveUserWithName->delete()) {
                    return false;
                }
            }
        }

        return true;
    }

    public static function findObject(array $where, array $columns = []) {
        if (!isset($where['status'])) {
            $where['status'] = ['value' => self::STATUS_ACTIVE];
        }

        return parent::findObject($where, $columns);
    }

}