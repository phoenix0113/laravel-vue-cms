<?php namespace Modules\User\Repositories\Sentinel;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Modules\Session\Exceptions\UserNotFoundException;
use Modules\User\Repositories\UserRepository;

class SentinelUserRepository implements UserRepository
{
    /**
     * @var \Modules\Session\Entities\User
     */
    protected $user;
    /**
     * @var \Cartalyst\Sentinel\Roles\EloquentRole
     */
    protected $role;

    public function __construct()
    {
        $this->user = Sentinel::getUserRepository()->createModel();
        $this->role = Sentinel::getRoleRepository()->createModel();
    }

    /**
     * Returns all the users
     * @return object
     */
    public function all()
    {
        return $this->user->all();
    }

    /**
     * Create a user resource
     * @return mixed
     */
    public function create($data)
    {
        return $this->user->create($data);
    }

    /**
     * Create a user and assign roles to it
     * @param array $data
     * @param array $roles
     * @return void
     */
    public function createWithRoles($data, $roles)
    {
        $user = $this->user->create($data);
        $user->roles()->attach($roles);

        $code = Activation::create($user);
        Activation::complete($user, $code);
    }

    /**
     * Find a user by its ID
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->user->find($id);
    }

    /**
     * Update a user
     * @param $user
     * @param $data
     * @return mixed
     */
    public function update($user, $data)
    {
        return $this->user->update($user, $data);
    }

    /**
     * @param $userId
     * @param $data
     * @param $roles
     * @internal param $user
     * @return mixed
     */
    public function updateAndSyncRoles($userId, $data, $roles)
    {
        $user = $this->user->find($userId);

        $user = $user->fill($data);
        $user->save();

        $user->roles()->sync($roles);
    }

    /**
     * Deletes a user
     * @param $id
     * @throws UserNotFoundException
     * @return mixed
     */
    public function delete($id)
    {
        if ($user = $this->user->find($id)) {
            return $user->delete();
        };

        throw new UserNotFoundException;
    }
}