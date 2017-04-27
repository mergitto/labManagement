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
        $favoriteFiles = $this->Favorites->find()->where(['Favorites.user_id' => $id])->contain(['Users','Attachments']);

        $attachments = $this->Favorites->Attachments->find()->contain(['Tags'])->all();

        $this->set(compact('favoriteFiles','attachments'));
        $this->set('_serialize', ['favorite']);
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
