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

/**
 * Events Controller
 *
 * @property \FullCalendar\Model\Table\EventsTable $Events
 */
class EventsController extends FullCalendarAppController
{
    public $name = 'Events';
    public $paginate = ['limit' => 15];
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $events = $this->Events->find('all');
        if ($this->request->is('requested')) {
            dump();
            $this->paginate = [
                'limit'   => 2,
                'order'   => ['Events.start' => 'desc']
            ];
            $this->response->body(json_encode($this->paginate($events)));
            return $this->response;
        } else {
            $this->paginate = [
                'limit'   => 12,
                'order'   => ['Events.start' => 'desc']
            ];
            $this->set('events', $this->paginate($events));
            $this->set('_serialize', ['events']);            
        }
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
        $event = $this->Events->get($id);
        $this->set('event', $event);
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
        $users = $this->Events->Users->find('list');
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
        $this->set(compact('event'));
        $this->set('_serialize', ['event', 'eventTypes']);
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

    // The feed action is called from "webroot/js/ready.js" to get the list of events (JSON)
    public function feed($id=null) {
        $this->viewBuilder()->layout('ajax');
        $vars = $this->request->query([]);
        $conditions = ['UNIX_TIMESTAMP(start) >=' => $vars['start'], 'UNIX_TIMESTAMP(start) <='];
        $events = $this->Events->find('all', $conditions)->contain(['EventTypes']);
        foreach($events as $event) {
            if($event->all_day === 1) {
                $allday = true;
                $end = $event->start;
            }
            $json[] = [
                    'id' => $event->id,
                    'title'=> $event->title,
                    'start'=> $event->start,
                    'allDay' => $allday,
                    'url' => Router::url(['action' => 'view', $event->id]),
                    'details' => $event->details,
                    'className' => $event->event_type->color
            ];
        }
        $this->set(compact('json'));
        $this->set('_serialize', 'json');
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

    public function logout(){
        return $this->redirect($this->Auth->logout());
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];
        // index, login, logoutページは誰でも見れる
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        // リクエストされたページのUser idと
        // ログイン中のUseridが一致する場合はその他のアクションも許可する
        $id = $this->request->params['pass'][0];
        $current_user = $this->Events->get($id);
        if ($current_user->id == $user['id']) {
            return true;
        }

        return false;
    }
}