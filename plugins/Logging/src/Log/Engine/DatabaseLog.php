<?php
namespace Logging\Log\Engine;

use Cake\Log\Engine\BaseLog;
use Cake\ORM\TableRegistry;

class DatabaseLog extends BaseLog{

    private $Model;

    public function __construct(array $config = []){
        parent::__construct($config);
    }

    public function log($level, $message, array $context = []){

        //Laden des Models
        if(!$context || !array_key_exists('model', $context)){
            $context['model'] = 'SystemLogs';
        }
        $this->Model = TableRegistry::get('Logger.'.$context['model']);

        $log_data = [
            'level' => $level,
            'message' => $message
        ]; 

        $entity = $this->Model->newEntity($log_data);
        $this->Model->save($entity);

        return true;
    }
}
?>