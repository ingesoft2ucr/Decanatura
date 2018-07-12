<?php
namespace App\Controller;
use App\Controller\AAppController;
/**
 * Models Controller
 *
 * @property \App\Model\Table\ModelsTable $Models
 *
 * @method \App\Model\Entity\Model[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ModelsController extends AppController
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
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		$this->paginate = [
            'contain' => ['Brands', 'Types']
        ];
        $models = $this->paginate($this->Models);
        $this->set(compact('models'));
    }
    /**
     * View method
     *
     * @param string|null $id Model id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $model = $this->Models->get($id, [
            'contain' => ['Brands', 'Types']
        ]);
        $this->set('model', $model);
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $model = $this->Models->newEntity();
        if ($this->request->is('post')) {
			
			$random = uniqid();
            $model->id = $random;
            $model = $this->Models->patchEntity($model, $this->request->getData());
			
			if ($_POST['new_Brand'] == '') {
				if ($this->Models->save($model)) {
                    AppController::insertLog($model['id'], TRUE);
					$this->Flash->success(__('El modelo fue guardado exitosamente.'));
					return $this->redirect(['action' => 'index']);
				}
                AppController::insertLog($model['id'], FALSE);
				$this->Flash->error(__('El modelo no se pudo guardar, por favor intente nuevamente.'));
				
			} else {

                $brand = $this->Models->Brands->newEntity();
                $random_id = uniqid();
                $brand->id = $random_id;
                $brand->name = $_POST['new_Brand'];

                $allBrands = $this->Models->Brands->find('all');
                foreach ($allBrands as $b) {
                   if ($b->name == $brand->name){
                        $brand->id = $b->id;
                        $brand->name = null;
                   }
                }
				
                if($brand->name == null){
                    $model->id_brand = $brand->id;
                    if ($this->Models->save($model)) {
                        $this->Flash->success(__('El modelo y la marca fueron guardados exitosamente.'));
                        return $this->redirect(['action' => 'index']);
                    }
                    $this->Flash->error(__('El modelo y la marca no se pudieron guardar, por favor intente nuevamente.'));
                }
                else {
                    if ($this->Models->Brands->save($brand)) {
                        $model->id_brand = $brand->id;
                        if ($this->Models->save($model)) {
                            $this->Flash->success(__('El modelo y la marca fueron guardados exitosamente.'));
                            return $this->redirect(['action' => 'index']);
                        }
                        $this->Flash->error(__('El modelo y la marca no se pudieron guardar, por favor intente nuevamente.'));
                    }
                }
			}
        }
		
		$brands = $this->Models->Brands->find('list', ['limit' => 200]);
		$types = $this->Models->Types->find('list', ['limit' => 200]);
        $this->set(compact('model', 'brands', 'types'));
    }
    /**
     * Edit method
     *
     * @param string|null $id Model id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $model = $this->Models->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $model = $this->Models->patchEntity($model, $this->request->getData());
			
            if ($_POST['new_Brand'] == '') {
				if ($this->Models->save($model)) {
                    AppController::insertLog($model['id'], TRUE);
					$this->Flash->success(__('El modelo fue modificado exitosamente.'));
					return $this->redirect(['action' => 'index']);
				}
                AppController::insertLog($model['id'], FALSE);
				$this->Flash->error(__('El modelo no se pudo modificar, por favor intente nuevamente.'));
				
			} else {
				$brand = $this->Models->Brands->newEntity();
				$random_id = uniqid();
				$brand->id = $random_id;
				$brand->name = $_POST['new_Brand'];

				if ($this->Models->Brands->save($brand)) {
					$model->id_brand = $brand->id;
					if ($this->Models->save($model)) {
						$this->Flash->success(__('El modelo y la marca fueron modificados exitosamente.'));
						return $this->redirect(['action' => 'index']);
					}
					$this->Flash->error(__('El modelo y la marca no se pudieron modificar, por favor intente nuevamente.'));
				}
			}
        }
        
		$brands = $this->Models->Brands->find('list', ['limit' => 200]);
		$types = $this->Models->Types->find('list', ['limit' => 200]);
        $this->set(compact('model', 'brands', 'types'));
    }
    /**
     * Delete method
     *
     * @param string|null $id Model id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $model = $this->Models->get($id);
        if ($this->Models->delete($model)) {
            AppController::insertLog($model['id'], TRUE);
            $this->Flash->success(__('El modelo de activo se ha eliminado exitosamente.'));
        } else {
            AppController::insertLog($model['id'], FALSE);
            $this->Flash->error(__('El modelo de activo no pudo ser eliminado. Por favor, intente de nuevo.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}

