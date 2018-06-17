<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Imagine;
/**
* Controlador para los activos de la aplicación
*/
class AssetsController extends AppController
{

    public function isAuthorized($user)
    {

        $this->Roles = $this->loadModel('Roles');
        $this->Permissions = $this->loadModel('Permissions');
        $this->RolesPermissions = $this->loadModel('RolesPermissions');

        $allowI = false;
        $allowM = false;
        $allowE = false;
        $allowC = false;
        
        $query = $this->Roles->find('all', array(
                    'conditions' => array(
                        'id' => $user['id_rol']
                    )
                ))->contain(['Permissions']);

        foreach ($query as $roles) {
            $rls = $roles['permissions'];
            foreach ($rls as $item){
                //$permisos[(int)$item['id']] = 1;
                if($item['nombre'] == 'Insertar Usuarios'){
                    $allowI = true;
                }else if($item['nombre'] == 'Modificar Usuarios'){
                    $allowM = true;
                }else if($item['nombre'] == 'Eliminar Usuarios'){
                    $allowE = true;
                }else if($item['nombre'] == 'Consultar Usuarios'){
                    $allowC = true;
                }
            }
        } 


        $this->set('allowI',$allowI);
        $this->set('allowM',$allowM);
        $this->set('allowE',$allowE);
        $this->set('allowC',$allowC);


        if ($this->request->getParam('action') == 'add'){
            return $allowI;
        }else if($this->request->getParam('action') == 'edit'){
            return $allowM;
        }else if($this->request->getParam('action') == 'delete'){
            return $allowE;
        }else if($this->request->getParam('action') == 'view'){
            return $allowC;
        }else{
            return $allowC;
        }


    }
    /**
     * Método para desplegar una lista con un resumen de los datos de activos
     */
    public function index()
    {
        
        $this->paginate = [
            'contain' => ['Types', 'Users', 'Locations']
        ];
        $assets = $this->paginate($this->Assets);
        $this->set(compact('assets'));
    }
    /**
     * Método para ver los datos completos de un activo
     */
    public function view($id = null)
    {
        $asset = $this->Assets->get($id, [
            'contain' => ['Types', 'Users', 'Locations']
        ]);
        $this->set('asset', $asset);
    }
    /**
     * Método para agregar nuevos activos al sistema
     */
    public function add()
    {
        $asset = $this->Assets->newEntity();
        if ($this->request->is('post')) {
            $random = uniqid();
            $fecha = date('Y-m-d H:i:s');
            $asset->created = $fecha;
            $asset->modified = $fecha;
            $asset->unique_id = $random;
            $asset->deletable = true;
            $asset->deleted = false;
            $asset->state = "Disponible";
            $asset = $this->Assets->patchEntity($asset, $this->request->getData()); 
            if ($this->Assets->save($asset)) {
                $this->Assets->addThumbnail($asset);
                
                $this->Flash->success(__('El activo fue guardado exitosamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El activo no se pudo guardar, por favor intente nuevamente.'));
        }
        $types = $this->Assets->Types->find('list', ['limit' => 200]);
        $users = $this->Assets->Users->find('list', ['limit' => 200]);
        $locations = $this->Assets->Locations->find('list', ['limit' => 200]);
        
        
        $brands = array(); 
        $this->paginate = [
            'contain' => ['Types', 'Users', 'Locations']
        ];
        $assets = $this->paginate($this->Assets);
        foreach ($assets as $filterBrand) {
            if (!in_array($filterBrand->brand, $brands)){
                array_push($brands, $filterBrand->brand);
            }
        }
        
        $this->set(compact('asset', 'types', 'users', 'locations', 'brands', 'assets'));
    }
    /**
     * Método para editar un activo en el sistema
     */
    public function edit($id = null)
    {
        $asset = $this->Assets->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $fecha = date('Y-m-d H:i:s');
            $asset->modified = $fecha;
            
            $asset = $this->Assets->patchEntity($asset, $this->request->getData());
            if ($this->Assets->save($asset)) {
                if($asset->image != NULL){
                    $this->Assets->addThumbnail();
                }
                $this->Flash->success(__('El activo fue guardado exitosamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El activo no se pudo guardar, por favor intente nuevamente.'));
        }
        $types = $this->Assets->Types->find('list', ['limit' => 200]);
        $users = $this->Assets->Users->find('list', ['limit' => 200]);
        $locations = $this->Assets->Locations->find('list', ['limit' => 200]);
        $this->set(compact('asset', 'types', 'users', 'locations'));
    }

    /**
     * Restaura un activo desactivado
     */
    public function restore($plaque){
        $asset = $this->Assets->get($plaque);
        $asset->deleted = false;
        $asset->state = 'Disponible';
        $fecha = date('Y-m-d H:i:s');
        $asset->modified = $fecha;

        if ($this->Assets->save($asset)) {
            $this->Flash->success(__('El activo fue activado exitosamente.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('El activo no se pudo activar correctamente.'));
        return $this->redirect(['action' => 'index']);
    }


    /**
     * Elimina solo logicamente los activos de la base de datos
     * 
     * @param asset
     * @return 0 - archivo no se eliminó correctamente, 1 - hard delete completado, 2 - soft delete completado
     */
    public function softDelete($plaque){
        $asset = $this->Assets->get($plaque);
        
        if($asset->deletable){
            if($this->Assets->delete($asset)){
                $this->Flash->success(__('El activo fue eliminado exitosamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El activo no se pudo eliminar correctamente.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $fecha = date('Y-m-d H:i:s');
        $asset->deleted = true;
        $asset->state = 'Desactivado';
        $asset->modified = $fecha;
        
        if ($this->Assets->save($asset)) {
            $this->Flash->success(__('El activo fue desactivado exitosamente.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('El activo no se pudo desactivar correctamente.'));
        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * Método para eliminar un activo del sistema
     */
    public function delete($asset)
    {
        if ($this->Assets->delete($asset)) {
            return 1;
        } else {
            return 0;
        }
    }
    


    /**
     * Método para agregar activos por lotes
     */
    public function batch($cantidad = null)
    {
        $asset = $this->Assets->newEntity();
        if ($this->request->is('post')) {
            
                
                /**$asset = array(
                    'plaque' => $this->$i,
                    'type_id' => '5b08417d8e257',
                    'brand' => 'Silla',
                    'model' => 'modelo1',
                    'state' => 'Activo',
                    'description' => 'silla generica, modelo 1',
                    'owner_id' => 1,
                    'responsable_id' => 1,
                    'location_id' => 1, 
                    'year' => '2018',
                    'lendable' => 0
                );*/
                //$this->Assets->clear();
                //$this->placa++;
                
        $cantidad = $this->request->getData('quantity');
        $placa = $this->request->getData('plaque');
        for ($i = 0; $i < $cantidad; $i++){
            $asset = array();
            $asset['Assets']['plaque'] = $placa;
            $asset['Assets']['type_id'] = '5b08417d8e257';
            $asset['Assets']['brand'] = 'Silla';
            $asset['Assets']['model'] = 'modelo1';
            $asset['Assets']['state'] = 'Activo';
            $asset['Assets']['description'] = 'silla generica, modelo 1';
            $asset['Assets']['owner_id'] = 1;
            $asset['Assets']['responsable_id'] = 1;
            $asset['Assets']['location_id'] = 1;
            $asset['Assets']['year'] = '2018';
            $asset['Assets']['lendable'] = 0;
            //meter una por una a la base
            $this->Assets->save($asset);
            //incrementar la placa
            $this->Assets->clear();
        }
        $this->Flash->success(__('Los activos fueron guardados'));
            return $this->redirect(['action' => 'index']);
        
        /**
        $asset = $this->Assets->patchEntity($asset, $this->request->getData());
        if ($this->Assets->save($asset)) {

        $this->Flash->success(__('El activo fue guardado'));
        return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('El activo no se pudo guardar, porfavor intente nuevamente'));
        */


        }

        $types = $this->Assets->Types->find('list', ['limit' => 200]);
        $users = $this->Assets->Users->find('list', ['limit' => 200]);
        $locations = $this->Assets->Locations->find('list', ['limit' => 200]);
        $this->set(compact('asset', 'types', 'users', 'locations'));
    }
}

