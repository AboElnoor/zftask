<?php

class Application_Model_DbTable_Rss extends Zend_Db_Table_Abstract
{
    protected $_name = 'rss';

    function addLink($link) {
        $row = $this->createRow();
        $row->link = $link;
        return $row->save();
    }

    function listLinks() {
        return $this->fetchAll()->toArray();
    }
}

