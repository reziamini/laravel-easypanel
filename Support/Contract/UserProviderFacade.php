<?php


namespace AdminPanel\Support\Contract;



use AdminPanel\Support\User\UserProvider;

/**
 * @method static makeAdmin(int $id)
 * @method static findUser(int $id)
 * @method static deleteAdmin(int $id)
 * @see UserProvider
 */
class UserProviderFacade extends BaseFacade
{

}
