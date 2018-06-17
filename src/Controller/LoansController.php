<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
* Controlador para los préstamos de la aplicación
*/
class LoansController extends AppController
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
     * Método para desplegar una lista con un resumen de los datos de prestamos
     */
    public function index()
    {

        $this->paginate = [
            'contain' => ['Users']
        ];

        $loans = $this->paginate($this->Loans);

        $this->set(compact('loans'));
    }

    /**
     * Método para ver los datos completos de un activo
     */
    public function view($id = null)
    {
        $loan = $this->Loans->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('loan', $loan);
    }

    /**
     * Método para agregar nuevos activos al sistema
     */
    public function add()
    {
        $this->loadModel('Assets');

        $loan = $this->Loans->newEntity();
        if ($this->request->is('post')) {
            $listaPlaques = $this->request->getData('checkList');
            $listaPlaques = explode(',', $listaPlaques);
            
            $random = uniqid();
            $loan->id = $random;
            $loan->estado = 'Activo';
            $loan = $this->Loans->patchEntity($loan, $this->request->getData());
            
            if ($this->Loans->save($loan)) {
                
                foreach($listaPlaques as $plaque){
                    
                    
                    $asset= $this->Assets->get($plaque, [
                        'contain' => []
                    ]);
                    
                    $asset->loan_id = $random;
                    $asset->state = 'Prestado';
                    $asset->deletable = false;
                    
                    if(!($this->Assets->save($asset))){
                        $this->Flash->error(__('El préstamo no se pudo guardar. Uno de los activos no se pudo guardar correctamente'));
                        return $this->redirect(['action' => 'index']);
                    }
                }

                $this->Flash->success(__('El activo fue guardado exitosamente.'));
                return $this->redirect(['action' => 'index']);
            }
            
            
            $this->Flash->error(__('El préstamo no se pudo guardar, por favor intente nuevamente.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->loadModel('Assets');

        $query = $this->Assets->find()
                        ->select(['assets.plaque', 'assets.brand', 'assets.model', 'assets.series'])
                        ->where(['assets.state' => "Disponible"])
                        ->where(['assets.lendable' => true])
                        ->where(['assets.deleted' => false])
                        ->toList();

        $size = count($query);

        $result = array_fill(0, $size, NULL);
        
        for($i = 0; $i < $size; $i++)
        {
            $result[$i] =(object)$query[$i]->assets;
        }

        $assets = $this->Assets->find('list', [
            'conditions' => ['assets.state' => 'Disponible']
        ]);
        $users = $this->Loans->Users->find('list', ['limit' => 200]);
        $this->set(compact('assets', 'loan', 'users', 'result'));
    }

    /*Cancelar para varios activos*/
    public function cancel($id)
    {
        $this->loadModel('Assets');
        
        $loan = $this->Loans->get($id, [
            'contain' => []
        ]);
        
        
        $loan->estado = 'Cancelado';
        
        if ($this->Loans->save($loan)){
            
            $assets = $this->Assets->find()
            ->where(['assets.loan_id' => $id])
            ->toList();
                
            foreach($assets as $asset){
                $asset->state = 'Disponible';
                $asset->loan_id = NULL;

                if(!($this->Assets->save($asset))){
                    $this->Flash->error(__('Error al cancelar el préstamo'));
                    return $this->redirect(['action' => 'index']);
                }
            }

            $this->Flash->success(__('El activo fue guardado exitosamente.'));
            return $this->redirect(['action' => 'index']);

        }
        else{
            $this->Flash->error(__('Error al cancelar el préstamo'));
            return $this->redirect(['action' => 'index']);
        }
        $assets = $this->Loans->Assets->find('list', ['limit' => 200]);
        $users = $this->Loans->Users->find('list', ['limit' => 200]);
        $this->set(compact('assets', 'loan', 'users'));
    }

    /**
     * Método para obtener todas las placas de activos del sistema y 
     * enviarlas como un JSON para que lo procese AJAX
     */
    public function getPlaques()
    {
        $this->loadModel('Assets');
        if ($this->requrest->is('ajax')) {
            $this->autoRender = false;

            $plaqueRequest = $this->request->query['term'];
            $results = $this->Assets->find($id, [
                'conditions' => [ 'OR' => [
                    'plaque LIKE' => $plaqueRequest . '%',
                    ]
                ]
            ]);
            
            $resultsArr = [];
            
            foreach ($results as $result) {
                $resultsArr[] =['label' => $result['plaque'], 'value' => $result->plaque];
            }
            
            echo json_encode($resultsArr);

        }
    }

    /**
     * Método para enviar la vista parcial de búsqueda de un activo por medio de AJAX
     */
    public function searchAsset()
    {
        $this->loadModel('Assets');
        $id = $_GET['id'];
        $searchedAsset= $asset= $this->Assets->get($id, [
                    'contain' => []
                ]);
        if(empty($searchedAsset) )
        {
            throw new NotFoundException(__('Activo no encontrado') );      
        }
        $this->set('serchedAsset', $searchedAsset);

        /*Asocia esta función a la vista /Templates/Layout/searchAsset.ctp*/
        $this->render('/Layout/searchAsset');
    }
}