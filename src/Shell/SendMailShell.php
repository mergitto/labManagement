<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Mailer\Email;

class SendMailShell extends Shell
{
    public function main(){
        $email = new Email('default');
        $email->to('merugitosu@gmail.com') //送信したいメールアドレスで書き直すこと
              ->subject('タイトル')
              ->send('本文');
    }
}
