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
        $this->loadComponent('AdminActivities');
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
            //Userssテーブルの(最後のID + 1)を取得する
            $lastId = $this->Admins->Users->find()->order(['Users.id' => 'DESC'])->first();
            //ファイルを提出したユーザー名を取得する
            $userName = $this->Auth->user();
            //ファイルの拡張を取得する
            $filePath = pathinfo($this->request->data['photo']['name']);
            //ファイル名(例):10-admin-2017.docx(id-userName-year.拡張子)
            $this->request->data['photo']['name'] = 1+$lastId['id'].'-user-'.date('Y').'.'.$filePath['extension'];
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
    /**
     * Activities View method
     * 管理者のみが全てのユーザーのActivitiesを変更追加できる
     */
    public function activities($userId = null)
    {
        $tasksModel = $this->loadModel('Tasks');
        $activitiesModel = $this->loadModel('Activities');
        $user = $this->Auth->user();
        $users = $activitiesModel->Users->find('list',['keyField' => 'id', 'valueField' => 'nickname'])->where(['Users.id !=' => $user['id']])->order(['Users.created' => 'ASC']);
        $activity = $activitiesModel->find()->where(['user_id' => $userId])->contain(['Users']);
        if(!$activity->isEmpty()){ // 研究テーマを登録している場合はActivitiesテーブルの情報を取得する
          $result = $activity->first();
          $plans = $activitiesModel->Plans->find()->where(['activity_id' => $result['id']])->order(['Plans.created' => 'ASC']);
        }
        $tasks = $tasksModel->find()->where(['user_id' => $userId])->contain(['Subtasks'])->order(['Tasks.created' => 'ASC']);
        $allTasks = $tasksModel->find()->contain(['Subtasks'])->order(['Tasks.created' => 'ASC']);
        $todayTasks = $tasksModel->find()
          ->where(['user_id' => $userId])
          ->where(['starttime <=' => date('Y-m-d H:i:s')])
          ->where(['status =' => PROCESS]) // status=処理中(PROCESS)という条件を付加
          ->contain(['Subtasks'])
          ->order(['Tasks.created' => 'ASC']);
        $subList = $this->AdminActivities->subTasksList($tasks);
        $taskRate = $this->AdminActivities->taskProgressRate($allTasks);
        $activities = $activitiesModel->find()->contain(['Users'])->order(['Activities.created' => 'ASC']);
        $this->set(compact('result', 'plans', 'tasks', 'subList', 'todayTasks', 'taskRate', 'activities', 'users'));
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
        $this->Flash->error(__('管理者のみの機能です'));
        // 管理者以外はアクセス拒否
        return false;
    }
}
