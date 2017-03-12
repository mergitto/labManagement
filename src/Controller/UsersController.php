<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $loginUser = $this->Auth->user();
        $users = $this->paginate($this->Users->find());

        $this->set(compact('users','loginUser'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Admins']
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('ユーザー情報を更新しました。'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('更新できませんでした。もう一度お試しください。'));
        }
        $admins = $this->Users->Admins->find('list', ['limit' => 200]);
        $this->set(compact('user', 'admins'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('ユーザーを削除しました。'));
        } else {
            $this->Flash->error(__('削除できませんでした。もう一度お試しください。'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login(){
        if ($this->request->is('post')) {
            //ユーザー認証成功時:trueが返される
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);    // データをセットしてログイン
                return $this->redirect(['controller' => 'users','action' => 'index']);
            } else {
                $this->Flash->error(
                    __("ログインできませんでした。/ You couldn't login."),
                    'default',
                    [],
                    'auth'
                );
            }
        }
    }

    public function logout(){
        return $this->redirect($this->Auth->logout());
    }
}
