<?php
/**
 * Stan Gumeniuk i@vig.gs
 * Date: 22.02.14
 * Time: 21:20
 */

namespace ByteHandAPI;

use ByteHandAPI\smser;

class message implements Interfaces\message
{
    private $to;
    private $text;
    private $after;

    private $id;
    private $status = "NEW";
    private $posted_at;
    private $updated_at;
    private $parts;
    private $cost;

    private $pushed = false;
    private $sended = false;
    private $inited = false;


    /* setter */


    public function to($to) {
        if (!$this->inited && !$this->pushed && !$this->sended) {
            $this->to = $to;
        } else {
            throw new \Exception('Message already init!');
        }
        return $this;
    }

    public function text($text) {
        if (!$this->inited && !$this->pushed && !$this->sended) {
            $this->text = $text;
        } else {
            throw new \Exception('Message already init!');
        }
        return $this;
    }

    public function after($after) {
        if (!$this->inited && !$this->pushed && !$this->sended) {
            $this->after = $after;
        } else {
            throw new \Exception('Message already init!');
        }
        return $this;
    }

    /* --- */
    public function __construct($id = false) {
        if ($id) {
            $this->id = $id;
            $this->initByID($this->id);

            $this->inited = true;
        }
    }


    public function send() {
        if (!$this->inited && !$this->pushed && !$this->sended) {
            $this->pushed = true;
            $status = smser::sendMessage(
                $this->getTo(),
                $this->getText(),
                $this->getAfter()
            );

            if ($status['status'] != 0) {
                throw new \Exception('Error! [' . $status['status'] . '] Message doesn\'t sent: ' . $status['description']);
            }

            $this->id = $status['description'];
            $this->initByID($this->id);
            $this->sended = true;
        } else {
            throw new \Exception('Message already init!');
        }
        return $this;
    }

    public function checkStatus() {
        if ($this->inited || $this->sended) {
            $this->initByID($this->id);
            return $this;
        } else {
            throw new \Exception('Message doesn\'t sent or inited!');
        }

    }

    /* private */

    private function initByID($id) {
        $status = smser::checkMessageStatus($id);
        if ($status['status'] != 0) {
            throw new \Exception('Error! [' . $status['status'] . '] initiating message by id ' . $id . " :" . $status['description']);
        }
        $this->status = $status['description'];
        $this->parts = $status['parts'];
        $this->posted_at = $status['posted_at'];
        $this->updated_at = $status['updated_at'];
        $this->cost = $status['cost'];
        return $this;
    }

    /* getter */
    public function getTo() {
        return $this->to;
    }

    public function getText() {
        return $this->text;
    }

    public function getAfter() {
        return $this->after;
    }

    public function getId() {
        return $this->id;
    }

    public function getPosted_at() {
        return $this->posted_at;
    }

    public function getUpdated_at() {
        return $this->updated_at;
    }

    public function getCost() {
        return $this->cost;
    }

    public function getStatus() {
        return $this->status;
    }

} 