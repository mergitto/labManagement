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
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $attachment = $this->Attachments->newEntity();
        if ($this->request->is('post')) {
            $attachment = $this->Attachments->patchEntity($attachment, $this->request->data);
            if ($this->Attachments->save($attachment)) {
                $this->Flash->success(__('登録しました'));

                return $this->redirect(['controller' => 'Events','action' => 'view',$attachment->event_id]);
            }
            $this->Flash->error(__('登録できませんでした'));
        }
        $event = $this->Attachments->Events->get($id);
        $this->set(compact('attachment', 'event'));
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
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $attachment = $this->Attachments->patchEntity($attachment, $this->request->data);
            if ($this->Attachments->save($attachment)) {
                $this->Flash->success(__('修正しました'));
                return $this->redirect(['controller' => 'Events' ,'action' => 'view', $attachment->event_id]);
            }
            $this->Flash->error(__('修正できませんでした。'));
        }
        $users = $this->Attachments->Users->find('list', ['limit' => 200]);
        $events = $this->Attachments->Events->find('list', ['limit' => 200]);
        $this->set(compact('attachment', 'users', 'events'));
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
