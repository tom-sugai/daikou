<?php
namespace App\Event;

use Cake\Event\EventListenerInterface;
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\SendMailComponent;
use App\Controller\Component\MathComponent;
use Cake\Error\Debugger;

/**
 * Class NotificationListener
 * @package App\Event
 */
class NotificationListener implements EventListenerInterface
{
    protected $Email;
    protected $Math;

    public function __construct()
    {
        $this->Email = new SendMailComponent(new ComponentRegistry());
        $this->Math = new MathComponent(new ComponentRegistry());
    }
    
    public function implementedEvents(): array
    {     
        return [
            'Notification.Math' => 'mathNotification'
        ];
         
        return [
            'Notification.E-Mail' => 'mailNotification'
        ];    
    }

    /**
     * Math 計算結果の通知
     * @param $amount1
     * @param $amount2
    */
    public function mathNotification($event, $amount1, $amount2)
    {
        $result = $this->Math->doComplexOperation($amount1, $amount2);
        debug($result);
    }

    /**
     * E-Mail通知処理
     * @param $event
     * @param $message
     */
    public function mailNotification($event, $message, $order)
    {
        $this->Email->send($message, $order);
    }
}