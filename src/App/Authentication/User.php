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
    private $id;

    /**
     * Represents user's login in the table users
     *
     * @var string
     */
    private $login;

    /**
     * Represents user's password (it's hash) in the table users
     *
     * @var string
     */
    private $password;

    /**
     * Represents user's salt in the table users
     *
     * @var string
     */
    private $salt;

    /**
     * Метод возвращает идентификационную информацию пользователя (первичный ключ в БД пользователей приложения)
     *
     * @return int
     */
    public function getId(): int
    {
        // TODO: Implement getId() method.
    }

    /**
     * Метод возвращает логин пользователя. Логин является уникальным свойством.
     *
     * @return string
     */
    public function getLogin(): string
    {
        // TODO: Implement getLogin() method.
    }

    /**
     * Метод возвращает пароль пользователя. Пароль возвращается в зашифрованном виде.
     *
     * @return string
     */
    public function getPassword(): string
    {
        // TODO: Implement getPassword() method.
    }

    /**
     * Метод возвращает соль, которая участвовала при построении пароля
     *
     * @return string|null
     */
    public function getSalt(): ?string
    {
        // TODO: Implement getSalt() method.
    }
}