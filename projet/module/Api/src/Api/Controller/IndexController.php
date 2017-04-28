<?php

namespace Api\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    protected $albumTable;
    
    public function indexAction()
    {
        $albums = $this->getAlbumTable()->fetchAll();
        return new ViewModel(
            array('albums' => $albums)
        );
    }

    public function printAction()
    {
        return new ViewModel();
    }

    /*
     * Include
     */
    public function getAlbumTable()
    {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Api\Model\AlbumTable');
        }
        return $this->albumTable;
    }

}

