<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Locations Controller
 *
 * @property \App\Model\Table\LocationsTable $Locations
 *
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationsController extends AppController
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
                if($item['nombre'] == 'Insertar Ubicaciones'){
                    $allowI = true;
                }else if($item['nombre'] == 'Modificar Ubicaciones'){
                    $allowM = true;
                }else if($item['nombre'] == 'Eliminar Ubicaciones'){
                    $allowE = true;
                }else if($item['nombre'] == 'Consultar Ubicaciones'){
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
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $locations = $this->paginate($this->Locations);

        $this->set(compact('locations'));
    }

    /**
     * View method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $location = $this->Locations->get($id, [
            'contain' => []
        ]);

        $this->set('location', $location);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $location = $this->Locations->newEntity();

        // De las locations, saco el ID más alto
        $tmpId = $this->Locations->find('all',['fields'=>'location_id'])->max('location_id');
        
        // Si el id que resultó es null (porque la tabla está vacía o no hay records para el año actual)
        if ($tmpId == null) {
            
            // Asigno el ID como 1
            $tmpId = 1;            
        }
        else{

            // De lo contrario, le sumo 1 al ID más grande
            $tmpId= $tmpId->location_id+1;
        }

        if ($this->request->is('post')) {

            $location = $this->Locations->patchEntity($location, $this->request->getData());

            // Asigno el ID nuevo
            $location->location_id = $tmpId;

            if ($this->Locations->save($location)) {
                AppController::insertLog($location['location_id'], TRUE);
                $this->Flash->success(__('Ubicación guardada.'));

                return $this->redirect(['action' => 'index']);
            }
            AppController::insertLog($location['location_id'], FALSE);
            $this->Flash->error(__('Ocurrió un error.'));
        }
        $this->set(compact('location'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $location = $this->Locations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $location = $this->Locations->patchEntity($location, $this->request->getData());
            if ($this->Locations->save($location)) {
                AppController::insertLog($location['location_id'], TRUE);
                $this->Flash->success(__('Ubicación guardada.'));

                return $this->redirect(['action' => 'index']);
            }
            AppController::insertLog($location['location_id'], FALSE);
            $this->Flash->error(__('Ocurrió un error.'));
        }
        $this->set(compact('location'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $location = $this->Locations->get($id);

        //Obtengo todos los assets que tengan como location el que quiero borrar
        $assets = TableRegistry::get('Assets')->find()->where(['location_id' => $location->location_id]);

        // De las locations que obtuve, saco el ID más alto, solo con la intención de confirmar que es null o no
        $tmpId = $assets->find('all',['fields'=>'plaque'])->max('plaque');

        // Si el resultado del query anterior es nulo, entonces lo puedo borrar
        if($tmpId == null){

            if ($this->Locations->delete($location)) {
                AppController::insertLog($location['location_id'], TRUE);
                $this->Flash->success(__('Se eliminó la ubicación.'));
            } 
        }
        else {
            AppController::insertLog($location['location_id'], FALSE);
                $this->Flash->error(__('La ubicación no se puede eliminar, ya que esisten activos asignados a ella.'));
            }

        return $this->redirect(['action' => 'index']);
    }
}
