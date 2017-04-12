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
            'limit'   => 8,
            'order'   => ['Events.start' => 'asc']
        ];

        foreach($allEvent as $event) {
            if($event->all_day === 1) {
                $allday = true;
                $end = $event->start;
            }
            $json[] = [
                    'id' => $event->id,
                    'title'=> $event->title,
                    'allday' => $event->allday,
                    'url' => Router::url(['action' => 'view', $event->id]),
                    'start'=> date('Y-m-d',strtotime($event->start)),
                    'end' => date('Y-m-d',strtotime($event->start)),
                    'details' => $event->details,
                    'user_id' => $event->user_id,
            ];
        }
        $this->set('json', h(json_encode($json,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)));

        $this->set(compact('allEvent'));
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
        $attachments = $this->paginate($this->Events->Attachments->find()->contain(['Users','Tags'])->where(['event_id' => $id]));
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

        $tagCount = array_count_values($tagCount);
        $this->set(compact('event','attachments','tags','tagCount','checkUsers'));
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
        $event = $this->Events->get($id);
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
        $users = $this->Events->Users->find('list');
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
}
