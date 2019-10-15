<?php

namespace App\Controllers;

use App\Models\User;
use Soda\Controller\WebController;
use Soda\Http\RedirectResponse;

class AuthController extends WebController
{
    public function login()
    {
        $user = new User([
            'username' => $this->request->get('username'),
            'password' => $this->request->get('password'),
        ]);

        if (getSession('user', null) == null && $user->getUsername() == 'admin' && $user->getPassword() == '123') {
            renewSession(true);
            setSession('user', $user);
        }

        return new RedirectResponse('/tasks/index');
    }

    public function logout()
    {
        eraseSession('user');
        renewSession(true);

        return new RedirectResponse('/tasks/index');
    }
}
