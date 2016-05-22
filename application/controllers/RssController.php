<?php

class RssController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
        $form = new Application_Form_Rss();
        $this->view->form = $form;

        if ($form->isValid($this->getRequest()->getPost())) {
            $link = $form->getValue('rsslink');

            $rss = new Application_Model_DbTable_Rss();
            if ($rss->addLink($link)) {
                $this->redirect('rss/read');
            }
        }
    }

    public function readAction() {
        $link = new Application_Model_DbTable_Rss();
        $links = $link->listLinks();

        $reader = new Zend_Feed_Reader();

        for ($i = 0; $i < count($links); $i++) {
//            echo '<pre>';
//            var_dump($links);
//die($links[$i]);
            $link = $reader->import($links[$i]['link']);

            $data[$i] = array(
                'title' => $link->getTitle(),
                'link' => $link->getLink(),
                'dateModified' => $link->getDateModified(),
                'description' => $link->getDescription(),
                'language' => $link->getLanguage(),
                'entries' => array(),
            );

            foreach ($link as $entry) {
                $edata = array(
                    'title' => $entry->getTitle(),
                    'description' => $entry->getDescription(),
                    'dateModified' => $entry->getDateModified(),
                    'authors' => $entry->getAuthors(),
                    'link' => $entry->getLink(),
                    'content' => $entry->getContent()
                );
                $data[$i]['entries'][] = $edata;
            }
        }
        $this->view->data = $data;
    }

}
