<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RolesPermissions Controller
 *
 * @property \App\Model\Table\RolesPermissionsTable $RolesPermissions
 *
 * @method \App\Model\Entity\RolesPermission[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolesPermissionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $rolesPermissions = $this->paginate($this->RolesPermissions);

        $this->set(compact('rolesPermissions'));
    }

    /**
     * View method
     *
     * @param string|null $id Roles Permission id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rolesPermission = $this->RolesPermissions->get($id, [
            'contain' => []
        ]);

        $this->set('rolesPermission', $rolesPermission);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rolesPermission = $this->RolesPermissions->newEntity();
        if ($this->request->is('post')) {
            $rolesPermission = $this->RolesPermissions->patchEntity($rolesPermission, $this->request->getData());
            if ($this->RolesPermissions->save($rolesPermission)) {
                $this->Flash->success(__('The roles permission has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The roles permission could not be saved. Please, try again.'));
        }
        $this->set(compact('rolesPermission'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Roles Permission id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rolesPermission = $this->RolesPermissions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rolesPermission = $this->RolesPermissions->patchEntity($rolesPermission, $this->request->getData());
            if ($this->RolesPermissions->save($rolesPermission)) {
                $this->Flash->success(__('The roles permission has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The roles permission could not be saved. Please, try again.'));
        }
        $this->set(compact('rolesPermission'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Roles Permission id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rolesPermission = $this->RolesPermissions->get($id);
        if ($this->RolesPermissions->delete($rolesPermission)) {
            $this->Flash->success(__('The roles permission has been deleted.'));
        } else {
            $this->Flash->error(__('The roles permission could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
