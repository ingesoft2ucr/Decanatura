<?php
namespace App\Controller;

use App\Controller\AppController;

/**
* Controlador para los préstamos de la aplicación
*/
class LoansController extends AppController
{

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
            
            $random = uniqid();
            $loan->id = $random;
            $loan->estado = 'Activo';
            $loan = $this->Loans->patchEntity($loan, $this->request->getData());
            
            if ($this->Loans->save($loan)) {
                $asset= $this->Assets->get($loan->id_assets, [
                    'contain' => []
                ]);

                $asset->state = 'Prestado';
                $asset->deletable = false;

                if($this->Assets->save($asset)){
                    $this->Flash->success(__('El préstamo fue guardado exitosamente.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('El préstamo no se pudo guardar, por favor intente nuevamente.'));
        }       
        $assets = $this->Loans->Assets->find('list', [
            'conditions' => ['assets.state' => 'Disponible']
        ]);
        $users = $this->Loans->Users->find('list', ['limit' => 200]);
        $this->set(compact('assets', 'loan', 'users'));
    }

    /**
     * Método para cancelar un préstamo
     */

    public function cancel($id)
    {
        $this->loadModel('Assets');
        $loan = $this->Loans->get($id, [
            'contain' => []
        ]);
        $loan->estado = 'Cancelado';
        if ($this->Loans->save($loan)){
            $asset= $this->Assets->get($loan->id_assets, [
                'contain' => []
            ]);
            $asset->state = 'Disponible';
            if($this->Assets->save($asset)){
                $this->Flash->success(__('El préstamo fue cancelado exitosamente.'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $assets = $this->Loans->Assets->find('list', ['limit' => 200]);
        $users = $this->Loans->Users->find('list', ['limit' => 200]);
        $this->set(compact('assets', 'loan', 'users'));
    }

/*Cancelar para varios activos*/
/*
    public function cancel($id)
    {
        $this->loadModel('Assets');
        
        $loan = $this->Loans->get($id, [
            'contain' => []
        ]);
        
        
        $loan->estado = 'Cancelado';
        
        if ($this->Loans->save($loan)){
            
            $assets = $this->Assets->find('list', [
                'conditions' => ['assets.loans_id' => $id]
            ]);
                
            foreach($assets as $asset){
                $asset->state = 'Disponible';

                if(!($this->Assets->save($asset))){
                    $this->Flash->success(__('Error al cancelar el préstamo'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
        $assets = $this->Loans->Assets->find('list', ['limit' => 200]);
        $users = $this->Loans->Users->find('list', ['limit' => 200]);
        $this->set(compact('assets', 'loan', 'users'));
    }*/

    /**
     * Método para obtener todas las placas de activos del sistema y 
     * enviarlas como un JSON para que lo procese AJAX
     */
    public function getPlaques()
    {
        pr('Sirve');
        die();
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