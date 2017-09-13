<?php
namespace App\Controller;

use App\Controller\AppController;
/**
 * Attachments Controller
 *
 * @property \App\Model\Table\AttachmentsTable $Attachments
 */
class AttachmentsController extends AppController
{
  /**
   * View method
   *
   * @return \Cake\Network\Response|null Redirects on successful view, renders view otherwise.
   */
   public function view()
   {
     $attachments = $this->Attachments->find()->contain(['Tags','Users'])->order(['Attachments.modified' => 'DESC']);
     $tags = $this->Attachments->Tags->find('list',['keyField' => 'id', 'valueField' => 'category']);
     $tagWhere = []; //postされたチェックボックスの状態をOR句として格納するための配列
     if($this->request->is('post')){
       //選択されたタグの条件を渡すための前処理
       for ($i=0; $i < count($this->request->data['Tags']['_ids']); $i++) {
         $tagWhere['OR'][] = [
           'Tags.id' => (int)$this->request->data['Tags']['_ids'][$i]
         ];
       }
       //チェックボックスに選択されたタグでOR検索をおこないファイル名でdistinctする
       $attachments = $this->Attachments->find()
         ->matching('Tags',function ($q) use($tagWhere){
           return $q->where($tagWhere);
         })->distinct(['Attachments.id']);
       $attachments = $attachments->contain(['Users']);
       //チェックボックスに選択されているもののタグを取り出す用
       $checkedTag = $this->Attachments->find()
         ->matching('Tags',function ($q) use($tagWhere){
           return $q->where($tagWhere);
         });
       //全てのタグを取り出す用
       $allTag = $this->Attachments->find()->contain(['Tags']);
     }
     //チェックボックス用のリスト確認
     $tagList = $this->Attachments->Tags->find();
     $checkedList = $tagList->where($tagWhere)->all();
     $this->set('attachments',$this->paginate($attachments));
     $this->set(compact('tags','checkedList','checkAttach','checkedTag','allTag'));
   }
    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $attachment = $this->Attachments->newEntity();
        $fileName = '';
        if ($this->request->is('post')) {
          //Attachmentsテーブルの(最後のID + 1)を取得する
          $lastId = $this->Attachments->find()->order(['Attachments.id' => 'DESC'])->first();
          //ファイルを提出したユーザー名を取得する
          $userName = $this->Auth->user();
          //ファイルの拡張を取得する
          $filePath = pathinfo($this->request->data['file']['name']);
          //ファイル名(例):10-admin-2017.docx(id-userName-year.拡張子)
          $fileName .= 1+$lastId['id'].'-'.$userName['name'].'-'.date('Y').'.'.$filePath['extension'];
          //ユーザーが提出したファイル名を避難させる(画面に表示するカラムとなる)
          $this->request->data['tmp_file_name'] = $this->request->data['file']['name'];
          //上で作成したファイル名を保存ファイル名とする(データベースにはこの名前で保存)
          $this->request->data['file']['name'] = $fileName;
          $attachment = $this->Attachments->patchEntity($attachment, $this->request->data);
          if ($this->Attachments->save($attachment)) {
              $this->Flash->success(__('登録しました'));
              return $this->redirect(['controller' => 'Events','action' => 'view',$attachment->event_id]);
          }
          $this->Flash->error(__('登録できませんでした'));
        }
        $event = $this->Attachments->Events->get($id);
        $tags = $this->Attachments->Tags->find('list',['keyField' => 'id','valueField' => 'category']);
        $this->set(compact('attachment', 'event','tags'));
        $this->set('_serialize', ['attachment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Attachment id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $attachment = $this->Attachments->get($id, [
            'contain' => ['Events','Tags']
        ]);
        $fileName = '';
        if ($this->request->is(['patch', 'post', 'put'])) {
          $filePath = pathinfo($this->request->data['file']['name']);
          $userName = $this->Auth->user();
          $fileName = $attachment['id'].'-'.$userName['name'].'-'.date('Y').'.'.$filePath['extension'];
          $this->request->data['tmp_file_name'] = $this->request->data['file']['name'];
          $this->request->data['file']['name'] = $fileName;
          $attachment = $this->Attachments->patchEntity($attachment, $this->request->data);
          if ($this->Attachments->save($attachment)) {
              $this->Flash->success(__('修正しました'));
              return $this->redirect(['controller' => 'Events' ,'action' => 'view', $attachment->event_id]);
          }
          $this->Flash->error(__('修正できませんでした。'));
        }
        $users = $this->Attachments->Users->find('list', ['limit' => 200]);
        $events = $this->Attachments->Events->find('list', ['limit' => 200]);
        $tags = $this->Attachments->Tags->find('list',['keyField' => 'id','valueField' => 'category']);
        $this->set(compact('attachment', 'users', 'events','tags'));
        $this->set('_serialize', ['attachment']);
    }

    /**
     * Download method
     * ファイルをダウンロードする
     */
    public function download($file_name = null)
    {
        $this->autoRender = false; // オートレンダーをOFFに
        $path = WWW_ROOT.'files/Attachments/file/'.$file_name;
        $this->response->file($path, [
            'download' => true,
            'name' => $file_name,
        ]);
        return $this->response;
    }

    /**
     * Delete method
     *
     * @param string|null $id Attachment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $attachment = $this->Attachments->get($id);
        if ($this->Attachments->delete($attachment)) {
            $this->Flash->success(__('削除しました'));
        } else {
            $this->Flash->error(__('削除できませんでした'));
        }

        return $this->redirect(['controller' => 'Events' ,'action' => 'view', $attachment->event_id]);
    }

        public function isAuthorized($user)
    {
        $action = $this->request->params['action'];
        // index, view, logoutページは誰でも見れる
        if (in_array($action, ['add','view','logout','download'])) {
            return true;
        }
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        // リクエストされたページのUser idと
        // ログイン中のUseridが一致する場合はその他のアクションも許可する
        $id = $this->request->params['pass'][0];
        $current_user = $this->Attachments->get($id);
        if ($current_user->user_id == $user['id']) {
            return true;
        }else{
            $this->Flash->error(__('他のユーザーのファイルは操作できません'));
            return false;
        }
        $this->Flash->error(__('管理者の機能です'));
        return false;
    }
}
