<?php

class Application_Form_Rss extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setAction('index');
        $this->setName('rss');
        $rsslink = new Zend_Form_Element_Text('rsslink');
        $rsslink->setLabel('Add RSS Link: ')
                ->setRequired('true')
                ->addFilter('stripTags')
                ->addFilter('stringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib("class", "form-control col-xs-6 col-md-3")
                ->addValidator(new Zend_Validate_Db_NoRecordExists(
                        array(
                    'table' => 'rss',
                    'field' => 'link',
                        )
        ));

        $this->addElement($rsslink);
    }

}
