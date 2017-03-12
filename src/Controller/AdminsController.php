<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Admins Controller
 *
 * @property \App\Model\Table\AdminsTable $Admins
 */
class AdminsController extends AppController
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
        $admins = $this->paginate($this->Admins);

        $this->set(compact('admins'));
        $this->set('_serialize', ['admins']);
    }

    /**
     * User add method
     * 管理者のみがユーザーを追加できるようにする
     * 
     */
    public function userAdd()
    {
        $user = $this->Admins->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Admins->Users->patchEntity($user, $this->request->data);
            if ($this->Admins->Users->save($user)) {
                $this->Flash->success(__('新規ユーザーが登録されました。'));

                return $this->redirect(['controller' => 'users' ,'action' => 'index']);
            }
            $this->Flash->error(__('新規ユーザー登録できませんでした。もう一度お試しください。'));
        }
        $admins = $this->Admins->find('list');
        $this->set(compact('user', 'admins'));
        $this->set('_serialize', ['user']);
    }


    public function logout(){
        return $this->redirect($this->Auth->logout());
    }

    /**
     * is Authorized method
     * 管理者(role=admin)のみがアクセスできるようにする
     * 
     */
    public function isAuthorized($user)
    {
        // 管理者のみのアクセスを許す
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        // 管理者以外はアクセス拒否
        return false;
    }
}
