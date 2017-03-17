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
                $this->Flash->success(__('The thread has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The thread could not be saved. Please, try again.'));
        }
        $user = $this->Auth->user();
        $this->set(compact('thread', 'user'));
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
        $user = $this->Auth->user();
        $this->set(compact('thread','user','post'));
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
        $user = $this->Auth->user();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $thread = $this->Threads->patchEntity($thread, $this->request->data);
            if ($this->Threads->save($thread)) {
                $this->Flash->success(__('The thread has been saved.'));

                return $this->redirect(['action' => 'index', $thread->id]);
            }
            $this->Flash->error(__('The thread could not be saved. Please, try again.'));
        }
        
        $this->set(compact('thread', 'user'));
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
            $this->Flash->success(__('The thread has been deleted.'));
        } else {
            $this->Flash->error(__('The thread could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];
        // index, login, logoutページは誰でも見れる
        if (in_array($action, ['index', 'login', 'logout','add','posts'])) {
            return true;
        }
        // 管理者のみのdeleteへのアクセスを許す
        if (isset($user['role']) && $user['role'] === 'admin') {
            if (in_array($action, ['delete'])) {
                return true;
            }
        }
        // リクエストされたページのUser idと
        // ログイン中のUseridが一致する場合はその他のアクションも許可する
        $id = $this->request->params['pass'][0];
        $current_user = $this->Threads->get($id,[
            'contain' => 'Users'
        ]);
        if ($current_user->user->id == $user['id']) {
            return true;
        }
        $this->Flash->error(__('同一ユーザーではありません'));
        return false;
    }
}
