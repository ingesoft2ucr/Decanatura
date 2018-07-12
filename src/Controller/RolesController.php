<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Controller\Component\AuthComponent;
/**
 * Roles Controller
 *
 * @property \App\Model\Table\RolesTable $Roles
   @property \App\Model\Table\PermissionsTable $Permissions
 *
 * @method \App\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolesController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
       
    }
    public function isAuthorized($user)
    {
        
        $this->Roles = $this->loadModel('Roles');
        $this->Permissions = $this->loadModel('Permissions');
        $this->RolesPermissions = $this->loadModel('RolesPermissions');
        
        $query = $this->Roles->find('all', array(
                    'conditions' => array(
                        'id' => $user['id_rol']
                    )
                ));
        foreach ($query as $roles) {
            if($roles['nombre'] == 'Administrador'){
                return true;
            }else{
                return false;
            }
        } 
        $this->set('allowI',$allowI);
        $this->set('allowM',$allowM);
        $this->set('allowE',$allowE);
        $this->set('allowC',$allowC);
        return true;
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('default');
        $roles = $this->paginate($this->Roles);
        $this->set(compact('roles'));
    }
    /**
     * View method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('default');
        $rol = $this->Roles->get($id, [
            'contain' => []
        ]);
        $this->set('rol', $rol);
        $this->Permissions = $this->loadModel('Permissions');
        $this->RolesPermissions = $this->loadModel('RolesPermissions');
        $permisos = array();
        for ($i = 1; $i < 29; ++$i) {
            $permisos[$i] = 0;
        }
        $id = $rol->id;
        $rol_activo = $rol->id;
        $query = $this->Roles->find('all', array(
            'conditions' => array(
                'id' => $id
            )
        ))->contain(['Permissions']);;
        foreach ($query as $roles) {
            $rls = $roles['permissions'];
            foreach ($rls as $item){
                $permisos[(int)$item['id']] = 1;
                //echo $item['id'];
                //echo "<br>";
            }
        } 
        if ($this->request->is('post')) {
            $checks = $this->request->data;
            $cant = 1;
            $cant_final = 29;
            $this->RolesPermissions->deleteAll(
                array(
                    "RolesPermissions.id_rol" => $rol_activo
                )
            );
            
            for($i=1;$i<$cant_final;$i++){
                if($checks[$i] == 1){
                    //INSERTA
                    $permiso = $this->RolesPermissions->newEntity();
                    
                    $permiso->id_rol = $rol_activo;
                    $permiso->id_permission = $i; 
                    if ($this->RolesPermissions->save($permiso)) {
                        $cant += 1;
                    }else{
                        //$this->Flash->error(__('The roles permission could not be saved. Please, try again.'));
                    }
                } else {
                    $cant += 1;
                }
            }
            if ($cant == $cant_final){
                $this->Flash->success(__('Se han salvado los permisos'));
            } else {
                $this->Flash->error(__('Ha habido un error al salvar los permisos. Porvafor intente de nuevo'));
            }
            $query = $this->Roles->find('all', array(
                'conditions' => array(
                    'id' => $rol_activo
                )
            ))->contain(['Permissions']);;
            foreach ($query as $roles) {
                $rls = $roles['permissions'];
                foreach ($rls as $item){
                    $permisos[(int)$item['id']] = 1;
                    //echo $item['id'];
                    //echo "<br>";
                }
            }
        }
        $this->set('permisos',$permisos);
        $this->set('rol_activo',$rol_activo);
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rol = $this->Roles->newEntity();
        if ($this->request->is('post')) {
            $rol = $this->Roles->patchEntity($rol, $this->request->getData());
            if ($this->Roles->save($rol)) {
                AppController::insertLog($rol['id'], TRUE);
                $this->Flash->success(__('El rol ha sido guardado.'));
                return $this->redirect(['action' => 'index']);
            }
            AppController::insertLog($rol['id'], FALSE);
            $this->Flash->error(__('El rol no ha podido ser guardado. Porfavor, intente de nuevo.'));
        }
        $this->set(compact('rol'));
    }
    /**
     * Edit method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rol = $this->Roles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rol = $this->Roles->patchEntity($rol, $this->request->getData());
            if ($this->Roles->save($rol)) {
                AppController::insertLog($rol['id'], TRUE);
                $this->Flash->success(__('El rol ha sido guardado.'));
                return $this->redirect(['action' => 'index']);
            }
            AppController::insertLog($rol['id'], FALSE);
            $this->Flash->error(__('El rol no ha podido ser guardado. Porfavor, intente de nuevo.'));
        }
        $this->set(compact('rol'));
    }
    /**
     * Delete method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rol = $this->Roles->get($id);
        if ($this->Roles->delete($rol)) {
            AppController::insertLog($rol['id'], TRUE);
            $this->Flash->success(__('El rol ha sido eliminado.'));
        } else {
            AppController::insertLog($rol['id'], FALSE);
            $this->Flash->error(__('El rol no ha podido ser eliminado. Porfavor, intente de nuevo.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}