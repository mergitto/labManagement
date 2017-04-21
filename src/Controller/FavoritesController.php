<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Favorites Controller
 *
 * @property \App\Model\Table\FavoritesTable $Favorites
 */
class FavoritesController extends AppController
{

    /**
     * Favorite ajax method
     *
     * @return \Cake\Network\Response|null
     */
     public function favAjax()
     {
       $favorite = $this->Favorites->newEntity();
       $this->autoRender = FALSE;
       if($this->request->is('ajax')) {
         if($this->request->data['favStatus'] == 'false') {
           $favorite = $this->Favorites->patchEntity($favorite, $this->request->data);
           if ($this->Favorites->save($favorite)) {
             echo json_encode($favorite->id);
           }
         }else{
           $favorite = $this->Favorites->get($this->request->data['favorite_id']);
           if ($this->Favorites->delete($favorite)) {
             $result = '削除';
             echo json_encode($result);
           }
         }
       }
     }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Attachments']
        ];
        $favorites = $this->paginate($this->Favorites);

        $this->set(compact('favorites'));
        $this->set('_serialize', ['favorites']);
    }

    /**
     * View method
     *
     * @param string|null $id Favorite id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $favorite = $this->Favorites->get($id, [
            'contain' => ['Users', 'Attachments']
        ]);

        $this->set('favorite', $favorite);
        $this->set('_serialize', ['favorite']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $favorite = $this->Favorites->newEntity();
        if ($this->request->is('post')) {
            $favorite = $this->Favorites->patchEntity($favorite, $this->request->data);
            if ($this->Favorites->save($favorite)) {
                $this->Flash->success(__('The favorite has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The favorite could not be saved. Please, try again.'));
        }
        $users = $this->Favorites->Users->find('list', ['limit' => 200]);
        $attachments = $this->Favorites->Attachments->find('list', ['limit' => 200]);
        $this->set(compact('favorite', 'users', 'attachments'));
        $this->set('_serialize', ['favorite']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Favorite id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $favorite = $this->Favorites->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $favorite = $this->Favorites->patchEntity($favorite, $this->request->data);
            if ($this->Favorites->save($favorite)) {
                $this->Flash->success(__('The favorite has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The favorite could not be saved. Please, try again.'));
        }
        $users = $this->Favorites->Users->find('list', ['limit' => 200]);
        $attachments = $this->Favorites->Attachments->find('list', ['limit' => 200]);
        $this->set(compact('favorite', 'users', 'attachments'));
        $this->set('_serialize', ['favorite']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Favorite id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $favorite = $this->Favorites->get($id);
        if ($this->Favorites->delete($favorite)) {
            $this->Flash->success(__('The favorite has been deleted.'));
        } else {
            $this->Flash->error(__('The favorite could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];
        // index, view, logoutページは誰でも見れる
        if (in_array($action, ['index','view','logout','favAjax'])) {
            return true;
        }
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        return false;
    }
}
