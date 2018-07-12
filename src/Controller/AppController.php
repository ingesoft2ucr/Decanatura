<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    public $components = array('RequestHandler');

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginaction' => [
                'controller' => 'users',
                'action' => 'login'
            ],
            'authorize' => array('Controller')
        ]);

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }


    /* public function isAuthorized($user)
     {

         // Admin can access every action
         if (isset($user['id_rol']) && $user['id_rol'] === '2') {
             return true;
         }

         // Default deny
         return false;
     }*/

    public function insertLog($pInProcess = null, $pSuccess = null)
    {
        if ($pSuccess) {
            $user_action = '';
            $user_message = '';
            if ($this->request->getParam('action') == 'add') {
                $user_action = 'Agregar';
                $user_message = 'Se agregó';
            } else if ($this->request->getParam('action') == 'edit') {
                $user_action = 'Modificar';
                $user_message = 'Se modificó';
            } else if ($this->request->getParam('action') == 'delete') {
                $user_action = 'Eliminar';
                $user_message = 'Se elimino';
            }
            $session = $this->request->getSession();
            $current_user = $session->read('Auth.User');
            $dateAndTime = date("Y-m-d H:i:s");
            $currentModule = $this->name;
            $conn = ConnectionManager::get('default');
            $stmt = $conn->execute('INSERT INTO activity_logs (DateAndTime,idUser,currentModule,userAction,message) values(\'' . $dateAndTime . '\', \'' . $current_user['id'] . '\',\'' . $currentModule . '\', \'' . $user_action . '\', \'' . $user_message . ' : ' . $pInProcess . '\');');
        } else {
            $user_action = 'ERROR';
            $user_message = '';
            if ($this->request->getParam('action') == 'add') {
                $user_message = 'No se agrego';
            } else if ($this->request->getParam('action') == 'edit') {
                $user_message = 'No se modifico';
            } else if ($this->request->getParam('action') == 'delete') {
                $user_message = 'No se elimino';
            }
            $session = $this->request->getSession();
            $current_user = $session->read('Auth.User');
            $dateAndTime = date("Y-m-d H:i:s");
            $currentModule = $this->name;
            $conn = ConnectionManager::get('default');
            $stmt = $conn->execute('INSERT INTO activity_logs (DateAndTime,idUser,currentModule,userAction,message) values(\'' . $dateAndTime . '\', \'' . $current_user['id'] . '\',\'' . $currentModule . '\', \'' . $user_action . '\', \'' . $user_message . ' : ' . $pInProcess . '\');');
        }
    }

    public function insertLogin($pInProcess = null, $pType = null  )
    {
            if ($pType) {
                $user_action = 'INICIO SESION';
                $user_message = 'inicio sesion';
            } else {
                $user_action = 'CIERRE SESION';
                $user_message = 'cerró sesion';
            }
            $session = $this->request->getSession();
            $current_user = $session->read('Auth.User');
            $dateAndTime = date("Y-m-d H:i:s");
            $currentModule = $this->name;
            $conn = ConnectionManager::get('default');
            $stmt = $conn->execute('INSERT INTO activity_logs (DateAndTime,idUser,currentModule,userAction,message) values(\'' . $dateAndTime . '\', \'' . $current_user['id'] . '\',\'' . $currentModule . '\', \'' . $user_action . '\', \'' . $user_message . ' : ' . $pInProcess . '\');');

    }

    public function beforeFilter(Event $event)
    {
        $this->Roles = $this->loadModel('Roles');
        $this->Permissions = $this->loadModel('Permissions');
        $this->RolesPermissions = $this->loadModel('RolesPermissions');

        $session = $this->request->getSession();
        $user = $session->read('Auth.User');

        $allowR = false;
        $allowU = false;
        $allowA = false;
        $allowRT = false;
        $allowUb = false;
        $allowP = false;
        $allowT = false;
        $allowD = false;
        $allowL = false;


        $query = $this->Roles->find('all', array(
            'conditions' => array(
                'id' => $user['id_rol']
            )
        ))->contain(['Permissions']);

        foreach ($query as $roles) {
            $rls = $roles['permissions'];
            foreach ($rls as $item) {
                if ($item['nombre'] == 'Consultar Usuarios') {
                    $allowU = true;
                } else if ($item['nombre'] == 'Consultar Activos') {
                    $allowA = true;
                } else if ($item['nombre'] == 'Consultar Reporte Tecnico') {
                    $allowRT = true;
                } else if ($item['nombre'] == 'Consultar Prestamos') {
                    $allowUb = true;
                } else if ($item['nombre'] == 'Consultar Ubicaciones') {
                    $allowP = true;
                } else if ($item['nombre'] == 'Consultar Traslados') {
                    $allowT = true;
                } else if ($item['nombre'] == 'Consultar Desechos') {
                    $allowD = true;
                }


            }
        }

        $query = $this->Roles->find('all', array(
            'conditions' => array(
                'id' => $user['id_rol']
            )
        ));
        foreach ($query as $roles) {
            if ($roles['nombre'] == 'Administrador') {
                $allowR = true;
                $allowL = true;
            }
        }


        $this->set('allowU', $allowU);
        $this->set('allowR', $allowR);
        $this->set('allowA', $allowA);
        $this->set('allowRT', $allowRT);
        $this->set('allowUb', $allowUb);
        $this->set('allowP', $allowP);
        $this->set('allowT', $allowT);
        $this->set('allowD', $allowD);
        $this->set('allowL', $allowL);

        $this->set('uid', $this->Auth->user('id'));
        $this->set('nombre', $this->Auth->user('nombre'));
        $this->set('apellido', $this->Auth->user('apellido1'));


        return parent::beforeFilter($event); // TODO: Change the autogenerated stub
    }


    /*
    public function beforeRender(Event $event) {
        $this->set('nombre', $this->Auth->user('nombre'));
        $this->set('apellido', $this->Auth->user('apellido1'));
        return parent::beforeFilter($event);
    }
   */


}