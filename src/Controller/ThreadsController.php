<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Threads Controller
 *
 * @property \App\Model\Table\ThreadsTable $Threads
 */
class ThreadsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $threads = $this->paginate($this->Threads);

        $this->set(compact('threads'));
        $this->set('_serialize', ['threads']);
    }


    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $thread = $this->Threads->newEntity();
        if ($this->request->is('post')) {
            $thread = $this->Threads->patchEntity($thread, $this->request->data);
            if ($this->Threads->save($thread)) {
                $this->Flash->success(__('タイトルを新規作成しました。'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('登録できませんでした。'));
        }
        $this->set(compact('thread'));
        $this->set('_serialize', ['thread']);
    }

    /**
     * Post method
     * 掲示板に対するコメントを表示する
     */
    public function posts($id = null)
    {
        $thread = $this->Threads->get($id,[
            'contain' => 'Posts'
        ]);
        $post = $this->Threads->Posts->newEntity();
        if ($this->request->is('post')) {
            $post = $this->Threads->Posts->patchEntity($post, $this->request->data);
            if ($this->Threads->Posts->save($post)) {
                $this->Flash->success(__('コメントが新しく登録されました。'));

                return $this->redirect(['action' => 'posts', $thread->id]);
            }
            $this->Flash->error(__('コメントが正しく登録されませんでした。'));
        }
        $this->set(compact('thread','post'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Thread id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $thread = $this->Threads->get($id, [
            'contain' => ['Users']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $thread = $this->Threads->patchEntity($thread, $this->request->data);
            if ($this->Threads->save($thread)) {
                $this->Flash->success(__('タイトル情報の変更を行いました'));

                return $this->redirect(['action' => 'index', $thread->id]);
            }
            $this->Flash->error(__('情報の変更を行えませんでした。'));
        }
        
        $this->set(compact('thread'));
        $this->set('_serialize', ['thread']);
    }

    /**
     * Post Edit method
     * コメントの編集
     */
    public function postEdit($id = null)
    {
        $post = $this->Threads->Posts->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->Threads->Posts->patchEntity($post, $this->request->data);
            if ($this->Threads->Posts->save($post)) {
                $this->Flash->success(__('コメントの修正を行いました'));

                return $this->redirect(['action' => 'Posts', $post['thread_id']]);
            }
            $this->Flash->error(__('情報の変更を行えませんでした。'));
        }
        
        $this->set(compact('thread','post'));
        $this->set('_serialize', ['thread']);
    }

    public function logout(){
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Delete method
     *
     * @param string|null $id Thread id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $thread = $this->Threads->get($id);
        if ($this->Threads->delete($thread)) {
            $this->Flash->success(__('タイトルを削除しました。'));
        } else {
            $this->Flash->error(__('削除できませんでした。'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Posts Delete method
     * コメント削除機能
     */
    public function postDelete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $thread = $this->Threads->Posts->get($id);
        if ($this->Threads->Posts->delete($thread)) {
            $this->Flash->success(__('コメントを削除しました。'));
        } else {
            $this->Flash->error(__('削除できませんでした。'));
        }
        return $this->redirect(['action' => 'posts', $thread['thread_id']]);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];
        // index, login, logoutページは誰でも見れる
        if (in_array($action, ['index', 'login', 'logout','add','posts','postEdit'])) {
            return true;
        }
        // リクエストされたページのUser idと
        // ログイン中のUseridが一致する場合はその他のアクションも許可する
        $id = $this->request->params['pass'][0];
        if ($action === 'postDelete' || $action === 'postEdit') {
            $current_user = $this->Threads->Posts->get($id,[
                'contain' => 'Users'
            ]);
            if ($current_user->user->id === $user['id']) {
                return true;
            }
        } else {
            $current_user = $this->Threads->get($id,[
                'contain' => 'Users'
            ]);
            if ($current_user->user->id == $user['id']) {
                return true;
            }
        }
        
        $this->Flash->error(__('同一ユーザーではありません'));
        return false;
    }
}
