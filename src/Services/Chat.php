<?php

namespace Services;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $rooms = array();

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->rooms["rooms"] = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        $this->rooms[uniqid()] = new \SplObjectStorage;

        $this->onSubscribe($conn, "rooms");
        echo "New connection! ({$conn->resourceId})\n";
    }


    public function onSubscribe(ConnectionInterface $conn, $room){
      $this->rooms["rooms"]->attach($conn);    
    }

    protected function broadcast($topic, $msg) {
        foreach ($this->rooms[$topic] as $client) {
            $client->send($msg);
        }
    }


    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;

        $msgData = json_decode($msg);

        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msgData->message, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msgData->message);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}

 ?>
