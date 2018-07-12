<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Dompdf\Dompdf;
use Cake\Datasource\ConnectionManager;


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
                if($item['nombre'] == 'Insertar Prestamos'){
                    $allowI = true;
                }else if($item['nombre'] == 'Modificar Prestamos'){
                    $allowM = true;
                }else if($item['nombre'] == 'Eliminar Prestamos'){
                    $allowE = true;
                }else if($item['nombre'] == 'Consultar Prestamos'){
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
        $this->loadModel('Assets');
        $query = $this->Assets->find()

                        ->select(['assets.plaque', 'assets.models_id', 'assets.series'])
                        ->where(['assets.loan_id' => $id])
                        ->toList();

        $size = count($query);

        $result = array_fill(0, $size, NULL);
        
        for($i = 0; $i < $size; $i++)
        {
            $result[$i] =(object)$query[$i]->assets;
        }
        $this->set(compact('loan', 'result'));
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
                        AppController::insertLog($loan['id'], FALSE);
                        $this->Flash->error(__('El préstamo no se pudo guardar. Uno de los activos no se pudo guardar correctamente'));
                        return $this->redirect(['action' => 'index']);
                    }
                }
                AppController::insertLog($loan['id'], TRUE);
                $this->Flash->success(__('El activo fue guardado exitosamente.'));
                //$this->download($loan->id);
                return $this->redirect(['action' => 'view',$loan->id]);
            }
            
            
            $this->Flash->error(__('El préstamo no se pudo guardar, por favor intente nuevamente.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->loadModel('Assets');

        $query = $this->Assets->find()
                        ->select(['assets.plaque', 'assets.models_id', 'assets.series'])
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
        $users = $this->Loans->Users->find('list', ['limit' => PHP_INT_MAX ]);
        $this->set(compact('assets', 'loan', 'users', 'result'));
    }

    /*Terminar para varios activos*/
    public function terminar($id)
    {
        if ($this->request->is('post')) {
            print_r($this->request->getData());
        }
        die();
        $this->loadModel('Assets');
        
        $loan = $this->Loans->get($id, [
            'contain' => []
        ]);
        
        
        $loan->estado = 'Terminado';
        
        if ($this->Loans->save($loan)){
            
            $assets = $this->Assets->find()
            ->where(['assets.loan_id' => $id])
            ->toList();
                
            foreach($assets as $asset){
                $asset->state = 'Disponible';
                $asset->loan_id = NULL;

                if(!($this->Assets->save($asset))){
                    $this->Flash->error(__('Error al terminar el préstamo'));
                    return $this->redirect(['action' => 'index']);
                }
            }

            $this->Flash->success(__('El préstamo ha sido finalizado.'));
            return $this->redirect(['action' => 'index']);

        }
        else{
            $this->Flash->error(__('Error al finalizar el préstamo'));
            return $this->redirect(['action' => 'index']);
        }
        $assets = $this->Loans->Assets->find('list', ['limit' => PHP_INT_MAX]);
        $users = $this->Loans->Users->find('list', ['limit' => PHP_INT_MAX ]);
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


    /**
     * Método para generar formulario
     */

    public function download($id = null)
    {

        $this->loadModel('Assets');
        

        $this->Assets = $this->loadModel('Assets');
        $this->AssetsTransfers = $this->loadModel('AssetsTransfers');

        $conn = ConnectionManager::get('default');
        $stmt = $conn->execute('SELECT * FROM assets
            inner join loans on loan_id = id
            where id =\'' . $id . '\';');

        $results = $stmt ->fetchAll('assoc');


         require_once 'dompdf/autoload.inc.php';
        //initialize dompdf class
        $document = new Dompdf();
        $html = 
        '
        <style>
        #element1 {float:left;margin-right:10px;} #element2 {float:right;} 
        table, td, th {
            border: 1px solid black;
        }
        body {
            border: 5px double;
            width:100%;
            height:100%;
            display:block;
            overflow:hidden;
            padding:30px 30px 30px 30px
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            height: 50px;
        }
        </style>
<center><img src="C:\xampp\htdocs\Decanatura\src\Controller\images\logoucr.png"></center>
<h2 align="center">UNIVERSIDAD DE COSTA RICA</h2>
<h2 align="center">UNIDAD DE ACTIVOS FIJOS</h2>
<h2 align="center">PRESTAMO DE ACTIVO FIJO</h2>
<p>&nbsp;</p>
<p align="right">Fecha._________________</p>
<p>&nbsp;</p>
<p align="center">Yo:_______________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cedula o carne:_______________</p>
<p>En calidad de:</p>
<p>Recibo en calidad de prestamo los equipos que a continuacion se detallan, los cuales estan asignados a:</p>

<table width="0" border="1">
<tbody>
<tr>
<th align="center">Placa</th>
<th align="center">Descripcion del Activo</th>
<th align="center">Marca</th>
<th align="center">Modelo</th>
<th align="center">Serie</th>
</tr>';

        foreach ($results as $item) {
            $html .= 
            '<tr>
             <td align="center">' . $item['plaque'] . '</td>
             <td align="center">' . $item['description'] . '</td>
             <td align="center">' . $item['brand'] . '</td>
             <td align="center">' . $item['models_id'] . '</td>
             <td align="center">' . $item['series'] . '</td>
             </tr>';
        }


$html .=

'</table>
<p>Acepto las condiciones que establecen los articulos No.13, No.14, No.17 y No.18 del Reglamento para la Administracion y Control de Bienes Institucionales de la U.C.R me compreto a usar el equipo adecuadamente, darle mantenimiento y devolverlo en buen estado en un plazo maximo que vence el:</p>
<p>&nbsp;</p>
<p align="center"><strong>Entrega:</strong><p>
<p align="center">Unidad de custodio:            _______________________<p>
<p align="center">Encargado de Bienes Institucionales:            _______________________<p>
<p align="center">Cedula:            _______________________<p>
<p align="center">Firma:            _______________________<p>
<p>&nbsp;</p>
<p align="center"><strong>Recibe:</strong><p>
<p align="center"><strong>Firma:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;______________________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha de devolucion: &nbsp;&nbsp;&nbsp;&nbsp;________________</strong></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><strong>Nota:</strong></p>
<p>El original de este documento sera entregado al solicitante despues de que se haya recibido satisfactoriamente el o los equipos.</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p align="center">Tels: 2511 5759/1149      www.oaf.ucr.ac.cr     correo electrónico: activosfijos.oaf@ucr.ac.cr</p>
        ';


        $document->loadHtml($html);

        //set page size and orientation
        $document->setPaper('A3', 'portrait');
        //Render the HTML as PDF
        $document->render();

        header( "refresh:5;url=index.php" );
        //Get output of generated pdf in Browser
        $document->stream("Formulario de Prestamo", array("Attachment"=>1));
        //1  = Download
        //0 = Preview

 

    }


}

