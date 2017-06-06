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
     * View method
     *
     * @param string|null $id Favorite id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $favoriteFiles = $this->Favorites->find()->where(['Favorites.user_id' => $id])->contain(['Users','Attachments']);

        $attachments = $this->Favorites->Attachments->find()->contain(['Tags','Favorites'])->all();
        $favoUser = $this->Auth->user();
        $persionalRankTags = []; //個人用のランキング
        $favoAttachments = $this->Favorites->find()->contain(['Attachments','Attachments.Tags'])->where(['Favorites.user_id' => $favoUser['id']]);
        foreach ($favoAttachments as $favorite) {
          foreach ($favorite->attachment->tags as $tag) {
            $persionalRankTags[] = $tag['category'];
          }
        }
        $allRankTags = []; //カウントされたタグ全てをカウントするもの
        // お気に入り登録されたファイルのタグ配列をいじりやすいように変更
        $allTags = []; // 全てのタグ
        foreach($persionalRankTags as $key => $tag) {
          $allTags[] = $tag;
        }
        $allTags = array_count_values($allTags); //配列に格納されている同じ項目のカウント
        $result = arsort($allTags);
        array_splice($allTags, 3); //上位3つまでの配列にする

        $this->set(compact('favoriteFiles','attachments','allTags'));
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
