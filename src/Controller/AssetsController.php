<?php
namespace App\Controller;

use App\Controller\AppController;
use Imagine;

/**
* Controlador para los activos de la aplicación
*/
class AssetsController extends AppController
{

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
            $asset = $this->Assets->patchEntity($asset, $this->request->getData());
            if ($this->Assets->save($asset)) {


                /*Si el archivo tiene imagen, crea un thumbnail*/
                if(!strlen($asset->image_dir) == 0){
                    $imagine = new Imagine\Gd\Imagine();

                    $size    = new Imagine\Image\Box(640, 640);

                    $mode    = Imagine\Image\ImageInterface::THUMBNAIL_INSET;

                    $imagine->open('../webroot/files/Assets/image/' .  $asset->unique_id . '/' . $asset->image)
                            ->thumbnail($size, $mode)
                            ->save('../webroot/files/Assets/image/' . $asset->unique_id . '/' . 'thumbnail.png');
                }

                $this->Flash->success(__('El activo fue guardado'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El activo no se pudo guardar, porfavor intente nuevamente'));
        }

        $types = $this->Assets->Types->find('list', ['limit' => 200]);
        $users = $this->Assets->Users->find('list', ['limit' => 200]);
        $locations = $this->Assets->Locations->find('list', ['limit' => 200]);
        $this->set(compact('asset', 'types', 'users', 'locations'));
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
            $asset = $this->Assets->patchEntity($asset, $this->request->getData());
            
            if ($this->Assets->save($asset)) {
            /*    
                
                if(!strlen($asset->image_dir) == 0){
                    $imagine = new Imagine\Gd\Imagine();

                    $size    = new Imagine\Image\Box(640, 640);

                    $mode    = Imagine\Image\ImageInterface::THUMBNAIL_INSET;

                    $imagine->open('../webroot/files/Assets/image/' .  $asset->unique_id . '/' . $asset->image)
                            ->thumbnail($size, $mode)
                            ->save('../webroot/files/Assets/image/' . $asset->unique_id . '/' . 'thumbnail.png');
                }*/

                $this->Flash->success(__('El activo fue guardado con exito'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El activo no se pudo guardar, porfavor intente nuevamente'));
        }
        $types = $this->Assets->Types->find('list', ['limit' => 200]);
        $users = $this->Assets->Users->find('list', ['limit' => 200]);
        $locations = $this->Assets->Locations->find('list', ['limit' => 200]);
        $this->set(compact('asset', 'types', 'users', 'locations'));
    }

    /**
     * Método para eliminar un activo del sistema
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $asset = $this->Assets->get($id);
        if ($this->Assets->delete($asset)) {
            $this->Flash->success(__('El activo fue borrado con exito'));
        } else {
            $this->Flash->error(__('El activo no se pudo borrar, porfavor intente nuevamente'));
        }

        return $this->redirect(['action' => 'index']);
    }

    
    /**
     * Método para agregar activos por lotes
     */
    var $placa = 1;
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
		//$cantidad = $this->Session->read('quantity');
		//$placa = $this->Post->field('plaque');

        /**for ($i = 0; $i < $cantidad; $i++){
            $asset = array();
            $asset['Asset']['plaque'] = $placa;
            $asset['Asset']['type_id'] = '5b08417d8e257';
            $asset['Asset']['brand'] = 'Silla';
            $asset['Asset']['model'] = 'modelo1';
            $asset['Asset']['state'] = 'Activo';
            $asset['Asset']['description'] = 'silla generica, modelo 1';
            $asset['Asset']['owner_id'] = 1;
            $asset['Asset']['responsable_id'] = 1;
            $asset['Asset']['location_id'] = 1;
            $asset['Asset']['year'] = '2018';
            $asset['Asset']['lendable'] = 0;
        }
        $this->Asset->saveBundle();
		*/
		for ($i = 0; $i < 5; $i++){
            $asset = $this->Assets->patchEntity($asset, $this->request->getData());
            if ($this->Assets->save($asset)) {

            $this->Flash->success(__('El activo fue guardado'));
            return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El activo no se pudo guardar, porfavor intente nuevamente'));
		}


        }

        $types = $this->Assets->Types->find('list', ['limit' => 200]);
        $users = $this->Assets->Users->find('list', ['limit' => 200]);
        $locations = $this->Assets->Locations->find('list', ['limit' => 200]);
        $this->set(compact('asset', 'types', 'users', 'locations'));
    }
}