<?php

namespace Api\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Api\Model\Album;
use Api\Form\AlbumForm;

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
    
    public function addAction()
    {
        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $album = new Album();
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $album->exchangeArray($form->getData());
                $this->getAlbumTable()->saveAlbum($album);

                // Redirect to list of albums
                return $this->redirect()->toRoute('api');
            }
        }
        return array('form' => $form);
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

