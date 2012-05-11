<?php
/**
 * This file is part of pgday2012-task
 *
 * Kartaca WBVS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * Kartaca WBVS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Kartaca WBVS. If not, see <http://www.gnu.org/licenses/>.
 *
 * @category   Kartaca
 * @copyright  Copyright (c) 2012 Kartaca (http://www.kartaca.com)
 * @license    http://www.gnu.org/licenses/ GPL
 */

class IndexController extends Zend_Controller_Action
{

    /**
     * Add New Task Form
     *
     * @var Zend_Form
     */
    private $_addForm;

    public function init()
    {
        $this->view->title = "PZFP: A Todo List";
        $this->_addForm = $this->_newTaskForm();
        $this->_helper->layout->disableLayout();
    }

    public function indexAction()
    {
        $this->_helper->layout->enableLayout();
    }
    
    public function listAction()
    {
        
    }
    
    public function formAction()
    {
        //TODO: Fill in the form details...
        $this->view->form = $this->_addForm;
    }
    
    public function saveAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        if ($this->_addForm->isValid($_POST)) {
            echo "You Task is saved!";
        }
    }
    
    private function _newTaskForm()
    {
        $form = new Zend_Form();
        $form->setAction(APPLICATION_BASEURL_INDEX . "/index/save");
        $form->setMethod("POST");
        $form->setAttrib("id", "new-task-form");
        $name = $form->createElement("text", "name");
        $submit = $form->createElement("submit", "save-btn");
        $submit->setAttrib("class", "btn btn-primary");
        
        $form->addElements(array($name, $submit));
        return $form;
    }
}

