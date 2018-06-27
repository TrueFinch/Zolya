<?php
/**
 * Created by PhpStorm.
 * User: truefinch
 * Date: 27.06.18
 * Time: 8:40
 */

namespace App\Authentication;


class User implements UserInterface
{
    /**
     * Represents user's id in the table users
     *
     * @var int
     */
    private $id_;

    /**
     * Represents user's login in the table users
     *
     * @var string
     */
    private $login_;

    /**
     * Represents user's password (it's hash) in the table users
     *
     * @var string
     */
    private $password_;

    /**
     * Represents user's salt in the table users
     *
     * @var string
     */
    private $salt_;

    public function __construct(int $id, string $login, string $password, string $salt)
    {
        $this->id_ = $id;
        $this->login_ = $login;
        $this->password_ = $password;
        $this->salt_ = $salt;
    }

    /**
     * Метод возвращает идентификационную информацию пользователя (первичный ключ в БД пользователей приложения)
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id_;
    }

    /**
     * Метод возвращает логин пользователя. Логин является уникальным свойством.
     *
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login_;
    }

    /**
     * Метод возвращает пароль пользователя. Пароль возвращается в зашифрованном виде.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password_;
    }

    /**
     * Метод возвращает соль, которая участвовала при построении пароля
     *
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return $this->salt_;
    }
}