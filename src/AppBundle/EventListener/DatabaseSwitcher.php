<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Connection;
use Exception;
use Monolog\Logger;

class DatabaseSwitcher {

    private $request;
    private $connection;
    private $logger;

    public function __construct(Request $request, Connection $connection, Logger $logger) {
        $this->request = $request;
        $this->connection = $connection;
        $this->logger = $logger;
    }

    public function onKernelRequest() {
        $session = $this->request->getSession();
        $tid = (string)$session->get('target_id');
        if ($tid != "") {
            
            $connection = $this->connection;
            $params     = $this->connection->getParams();

            $db_name = 'db_'.$tid.'_new';
            
            if ($db_name != $params['dbname']) {
                $params['dbname'] = $db_name;
                $params['user'] = "u".$tid;
                
                $params['password']=$tid[0].$tid[1]."mod".$tid[2]."bus".$tid[3].$tid[4];
                
                if ($connection->isConnected()) {
                    $connection->close();
                }
                $connection->__construct(
                    $params, $connection->getDriver(), $connection->getConfiguration(),
                    $connection->getEventManager()
                );

                try {
                    $connection->connect();
                } catch (Exception $e) {
                }
            }
        }
    }

}
