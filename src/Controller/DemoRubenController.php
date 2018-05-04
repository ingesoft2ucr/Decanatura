<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DemoRuben Controller
 *
 *
 * @method \App\Model\Entity\DemoRuben[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DemoRubenController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
      $this->viewBuilder()->setLayout('default');
       // $demoRuben = $this->paginate($this->DemoRuben);

       // $this->set(compact('demoRuben'));
    }

    /**
     * View method
     *
     * @param string|null $id Demo Ruben id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $demoRuben = $this->DemoRuben->get($id, [
            'contain' => []
        ]);

        $this->set('demoRuben', $demoRuben);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $demoRuben = $this->DemoRuben->newEntity();
        if ($this->request->is('post')) {
            $demoRuben = $this->DemoRuben->patchEntity($demoRuben, $this->request->getData());
            if ($this->DemoRuben->save($demoRuben)) {
                $this->Flash->success(__('The demo ruben has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The demo ruben could not be saved. Please, try again.'));
        }
        $this->set(compact('demoRuben'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Demo Ruben id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $demoRuben = $this->DemoRuben->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $demoRuben = $this->DemoRuben->patchEntity($demoRuben, $this->request->getData());
            if ($this->DemoRuben->save($demoRuben)) {
                $this->Flash->success(__('The demo ruben has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The demo ruben could not be saved. Please, try again.'));
        }
        $this->set(compact('demoRuben'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Demo Ruben id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $demoRuben = $this->DemoRuben->get($id);
        if ($this->DemoRuben->delete($demoRuben)) {
            $this->Flash->success(__('The demo ruben has been deleted.'));
        } else {
            $this->Flash->error(__('The demo ruben could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
