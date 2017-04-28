<?php
/*
 * Controller/EventsController.php
 * CakePHP Full Calendar Plugin
 *
 * Copyright (c) 2010 Silas Montgomery
 * http://silasmontgomery.com
 *
 * Licensed under MIT
 * http://www.opensource.org/licenses/mit-license.php
 */

namespace App\Controller;

use App\Controller\FullCalendarAppController;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
/**
 * Events Controller
 *
 * @property \FullCalendar\Model\Table\EventsTable $Events
 */
class EventsController extends FullCalendarAppController
{
    public $name = 'Events';

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        //カレンダー表示用
        $allEvent = $this->Events->find('all');
        //今日を含む今日以降の予定のみの検索
        $events = $this->Events->find('all')->contain(['Attachments','Users'])->where(['start >=' => date('Y-m-d')]);
        $this->paginate = [
            'limit'   => 4,
            'order'   => ['Events.start' => 'asc']
        ];

        $rankTags = []; //タグの順位を作成するための配列
        $attachments = $this->Events->Attachments->find()->contain(['Tags','Favorites']);
        foreach ($attachments as $key => $attachment) {
          if(array_key_exists(0,$attachment->favorites)){
            foreach ($attachment->tags as $key => $tag) {
              $rankTags[] = $tag->category;
            }
          }
        }
        $rankTags = array_count_values($rankTags); //配列に格納されている同じ項目のカウント
        $result = arsort($rankTags);
        array_splice($rankTags, 3); //上位3つまでの配列にする

        foreach($allEvent as $event) {
            if($event->all_day === 1) {
                $allday = true;
                $end = $event->start;
            }
            $json[] = [
                    'id' => $event->id,
                    'title'=> $event->title,
                    'url' => Router::url(['action' => 'view', $event->id]),
                    'start'=> date('Y-m-d',strtotime($event->start)),
            ];
        }

        //その日のゼミにファイルを登録しているかをチェックする
        $checkUsers = [];
        $submittedUsers = [];
        foreach ($events as $key => $event) {
          foreach ($event->attachments as $at) {
            if(!is_null($at->file)){
              $checkUsers[$event->id][] = $at->user_id;
            }
          }
          //ゼミに登録されているユーザの数
          $countUsers[$event->id] = count($event->users);
          foreach ($event->users as $key => $eventUser) {
            if(array_search($eventUser->id, $checkUsers[$event->id])){
              //ゼミに登録されているユーザの内ファイルを提出したユーザ
              $submittedUsers[$event->id][] = 'SUBMITTED';
            }
          }
        }
        $this->set('json', h(json_encode($json,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)));

        $this->set(compact('allEvent','checkUsers','countUsers','submittedUsers','rankTags'));
        $this->set('events', $this->paginate($events));
        $this->set('_serialize', ['events']);
    }

    /**
     * View method
     *
     * @param string|null $id Event id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $event = $this->Events->get($id,[
          'contain' => ['Users','Attachments']
        ]);
        $attachments = $this->paginate($this->Events->Attachments->find()->contain(['Users','Tags','Favorites','Scores'])->where(['event_id' => $id]));
        $tags = $this->Events->Attachments->find()->contain(['Tags']);
        //タグをカウントする
        $tagCount = [];
        foreach ($tags as $at) {
          foreach ($at->tags as $tags) {
            $tagCount[] = $tags['category'];
          }
        }
        //ファイルを提出しているユーザーの配列を作成する
        $checkUsers = [];
        foreach ($attachments as $check) {
          if(!is_null($check->file)){
            $checkUsers[] = $check->user['name'];
          }
        }
        //Favorite,Scoreユーザーの一覧配列を作成する
        $favUser = [];
        $favId = [];
        $scUser = [];
        $scId = [];
        $scVal = [];
        foreach ($attachments as $key => $attachment) {
          $favUser[$attachment->id][] = 'CREATE';
          foreach ($attachment->favorites as $favorite) {
            $favUser[$favorite->attachment_id][] = $favorite->user_id;
            $favId[$favorite->user_id][$favorite->attachment_id][] = $favorite->id;
          }
          foreach ($attachment->scores as $score) {
            $scUser[$score->attachment_id][] = $score->user_id;
            $scId[$score->user_id][] = [
                'user_id' => $score->user_id,
                'attachment_id' => $score->attachment_id,
                'score_id' => $score->id,
                'score' => $score->score,
            ];
          }
        }
        $tagCount = array_count_values($tagCount);
        $this->set(compact('event','attachments','tags','tagCount','checkUsers','favUser','favId','scId'));
        $this->set('_serialize', ['event']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $event = $this->Events->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['start'] = date('Y-m-d H:i:s' ,strtotime($this->request->data['start']));
            $event = $this->Events->patchEntity($event, $this->request->data);
            if ($this->Events->save($event)) {
                $this->Flash->success(__('予定を追加しました。'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('追加できませんでした。'));
            }
        }
        $users = $this->Events->Users->find('list');
        $this->set(compact('event','users'));
        $this->set('_serialize', ['event']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Event id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $event = $this->Events->get($id,['contain' => ['Users']]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->data['start'] = date('Y-m-d H:i:s' ,strtotime($this->request->data['start']));
            $event = $this->Events->patchEntity($event, $this->request->data);
            if ($event_id = $this->Events->save($event)) {
                $this->Flash->success(__('予定を修正しました。'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('修正できませんでした。'));
            }
        }
        $users = $this->Events->Users->find('list',['keyField' => 'id','valueField' => 'name']);
        $this->set(compact('event','users'));
        $this->set('_serialize', ['event']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Event id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $event = $this->Events->get($id);
        if ($this->Events->delete($event)) {
            $this->Flash->success(__('予定を削除しました。'));
        } else {
            $this->Flash->error(__('削除できませんでした。'));
        }
        return $this->redirect(['action' => 'index']);
    }

    // The update action is called from "webroot/js/ready.js" to update date/time when an event is dragged or resized
    public function update($id = null)
    {
        if ($this->request->is('ajax')) {
            $this->request->accepts('application/json');
            $debuggedData = debug($this->request->data);
            $event = $this->Events->get($id);
            $event = $this->Events->patchEntity($event, $this->request->data);
            $this->Events->save($event);
            $this->set(compact('event'));
            $this->response->body(json_encode($this->request->data));
            return $this->response;
        }
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];
        // index, view, logoutページは誰でも見れる
        if (in_array($action, ['index','view','logout'])) {
            return true;
        }
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        // addページは一般ユーザーには使用できないようにする
        if (in_array($action, ['add'])) {
            $this->Flash->error(__('管理者の機能です'));
            return false;
        }
        // リクエストされたページのUser idと
        // ログイン中のUseridが一致する場合はその他のアクションも許可する
        $id = $this->request->params['pass'][0];
        $current_user = $this->Events->get($id);
        if ($current_user->id == $user['id']) {
            return true;
        }
        $this->Flash->error(__('管理者の機能です'));
        return false;
    }

    /**
    * Get Unique Array Method
    * 多次元配列から一致するものだけに置き換える関数
    * いつか使うかもしれないから残す
    */
    public static function getUniqueArray($array, $column)
    {
       $tmp = [];
       $uniqueArray = [];
       foreach ($array as $value){
          if (!in_array($value[$column], $tmp)) {
             $tmp[] = $value[$column];
             $uniqueArray[] = $value;
          }
       }
       return $uniqueArray;
    }
}
