<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
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
        $users = $this->paginate($this->Users->find()->order(['id' => 'asc']));

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
        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $hasher = new DefaultPasswordHasher;
            $passwordCheck = $hasher->check($this->request->data['confirm_password'],$user->password);
            if(!$passwordCheck){
                $this->Flash->error(__('パスワードが間違ってます。'));
                return $this->redirect(['action' => 'edit', $user->id]);
            }
            $userName = $this->Auth->user();
            $filePath = pathinfo($this->request->data['photo']['name']);
            $this->request->data['photo']['name'] = $user['id'].'-user-'.date('Y').'.'.$filePath['extension'];
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('ユーザー情報を更新しました。'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('更新できませんでした。もう一度お試しください。'));
        }
        $admins = $this->Users->Admins->find('list', ['limit' => 200]);
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Evaluation method
     *
     * @param string|null $id User id
     */
    public function evaluation($id = null)
    {
      $user = $this->Users->get($id,[
        'contain' => ['Events']
      ]);
      $attachments = $this->Users->Events->Attachments->find()->where(['Attachments.user_id' => $id])->contain(['Scores', 'Favorites']);
      $iineEval = $this->iineEvalCount($attachments, $user);
      $attachmentFlag = $this->atFlag($attachments);
      $today = getdate(); // 現在の時刻を取得
      $todayHour = $today['hours'];
      if($todayHour == 0){ $todayHour = 24; }
      $this->set(compact('user', 'attachments', 'iineEval', 'todayHour', 'attachmentFlag'));
    }

    /**
     * TaskModalFlag method
     * @param integer $flag 0 or 1
     */
    public function taskModalFlag()
    {
      $this->autoRender = FALSE;
      if($this->request->is('ajax')) {
        $user = $this->Users->get($this->request->data['id']);
        $user->accessible('task_modal_flg', true);
        $user->task_modal_flg = $this->request->data['task_modal_flg'];
        if($this->Users->save($user)){
          echo json_encode($user);
        }
      }
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
                return $this->redirect(['controller' => 'Events','action' => 'index']);
            } else {
                $this->Flash->error(
                    __("ログインできませんでした。"),
                    'default',
                    [],
                    'auth'
                );
            }
        }
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];
        // index, login, logoutページは誰でも見れる
        if (in_array($action, ['index', 'taskModalFlag', 'login', 'logout'])) {
            return true;
        }
        // リクエストされたページのUser idと
        // ログイン中のUseridが一致する場合はその他のアクションも許可する
        $id = $this->request->params['pass'][0];
        $current_user = $this->Users->get($id);
        if ($current_user->id == $user['id']) {
            return true;
        }

        return false;
    }

    /**
     * method iineEvalCount
     * @param array Attachments
     * @return array iineEvaluationCount
     */
    public function iineEvalCount($attachments, $user)
    {
      $evaluationSum = 0; // 評価点数の合計
      $countEval = 0; // 評価している人のカウンタ
      $countIine = 0; // いいねしている人のカウンタ
      $scoreRange = []; // 得点ごとにカウント 例: 1点をつけた人の数、2点をつけた人の数
      foreach ($attachments as $attachment) {
        foreach ($attachment->scores as $score) {
          if($score->user_id != $user['id']){
            $evaluationSum += $score->score;
            $countEval++;
            $scoreKey = $score->score.'点';
            if(array_key_exists($scoreKey, $scoreRange)) { //得点ごとにカウント
              $scoreRange[$scoreKey] += 1;
            } else {
              $scoreRange[$scoreKey] = 1;
            }
          }
        }
        foreach ($attachment->favorites as $favorite) {
          $countIine++;
        }
      }
      for($i = 1; $i <= MAXSCORE; $i++){
        $key = $i.'点';
        if(array_key_exists($key, $scoreRange)){ //１、２点のような得点しなそうなパターンにも対応する
        } else {
          $scoreRange[$key] = 0;
        }
      }
      ksort($scoreRange); //キーの値で昇順にソート
      if($countEval == 0) {
        $average = 0;
      }else{
        $average = round($evaluationSum / $countEval, 1); // 小数点第一位まで四捨五入
      }
      return array('evalAverage' => $average, 'iine' => $countIine, 'scoreRange' => $scoreRange);
    }

    /**
    * method atFlag
    * @param array Attachments
    * @return boolean
    **/
    public function atFlag($attachments)
    {
      $count = 0;
      foreach ($attachments as $attachment) {
        $count++;
      };
      if($count == 0) {
        return false;
      }
      return true;
    }
}
