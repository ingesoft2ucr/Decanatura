<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Controller\Component\AuthComponent;
use Cake\Datasource\ConnectionManager;

/**
 * Login Controller
 *
 *
 * @method \App\Model\Entity\Login[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LoginController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
     $this->viewBuilder()->setLayout('login');

     if($this->request->is('post')){
        $user = $this->Auth->identify();
        if($user){
            $this->Auth->setUser($user);
            AppController::insertLogin($user['nombre'], TRUE);
            return $this->redirect('/');
        }
        $this->Flash->error(__('Usuario o contaseña inválidos, intente otra vez'));
    }

    }


public function logout($name){

    AppController::insertLogin($name, FALSE);
    return $this->redirect($this->Auth->logout());
}


    public function isAuthorized($user)
    {

        // Admin can access every action
        if (true) {
            return true;
        }

        // Default deny
        return false;
    }



}
