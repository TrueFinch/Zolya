<?php
/**
 * Created by PhpStorm.
 * User: truefinch
 * Date: 27.06.18
 * Time: 4:03
 */

namespace App\Authentication\Repository;


use App\Authentication\UserInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * MySQL database reference
     * @var \mysqli
     */
    private $db_;

    public function __construct($database)
    {
        $this->db_ = $database;
    }

    /**
     * Метод ищет пользователя по индентификатору, возвращает UserInterface если пользователь существует, иначе null
     *
     * @param int $id
     * @return UserInterface|null
     */
    public function findById(int $id): ?UserInterface
    {
        $query = $this->db_->prepare('SELECT * FROM users WHERE id = :id');
        $query->bind_param(':id', $id);
        $query->execute();
        $record = $query->get_result()->fetch_assoc();
        $query->close();
        return ($record) ? ($record) : (null);
        // TODO: Implement findById() method.
        // TODO: Rewrite return part - we need return UserInterface instead of array.
    }

    /**
     * Метод ищет пользователя по login, возвращает UserInterface если пользователь существует, иначе null
     *
     * @param string $login
     * @return UserInterface|null
     */
    public function findByLogin(string $login): ?UserInterface
    {
        $query = $this->db_->prepare('SELECT * FROM users WHERE login = :login');
        $query->bind_param(':login', $login);
        $query->execute();
        $record = $query->get_result()->fetch_assoc();
        $query->close();
        return ($record) ? ($record) : (null);
        // TODO: Implement findByLogin() method.
        // TODO: Rewrite return part - we need return UserInterface instead of array.
    }

    /**
     * Метод сохраняет пользоваля в хранилище
     *
     * @param UserInterface $user
     */
    public function save(UserInterface $user)
    {
        if ($user) {
            $query = $this->db_->prepare('Insert into users (login, password, salt) 
                                                 values (:login, :password, :salt)');
            $query->bind_param(':login', $user->getLogin());
            $query->bind_param(':password', $user->getPassword());
            $query->bind_param(':salt', $user->getSalt());
            $query->execute();
            $query->close();
        }
    }
}