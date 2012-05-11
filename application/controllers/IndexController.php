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
    
    /**
     * Data Table
     *
     * @var TasksTable
     */
    private $_dataTable;

    public function init()
    {
        $this->view->title = "PZFP: A Todo List";
        $this->_addForm = $this->_newTaskForm();
        $this->_helper->layout->disableLayout();
        $this->_dataTable = new TasksTable();
        //Run the updater to update all the tasks' statuses!!
        $this->_dataTable->updateTaskStatuses();
    }

    public function indexAction()
    {
        $this->_helper->layout->enableLayout();
    }
    
    public function listAction()
    {
        $this->view->items = $this->_dataTable->findAll();
    }
    
    public function formAction()
    {
        $this->view->form = $this->_addForm;
    }
    
    public function saveAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $message = array("success" => 0, "message" => "Please Correct the Errors Below!");
        if ($this->_addForm->isValid($_POST)) {
            //As everything is ok, save it...
            $task = $this->_dataTable->createRow();
            $task->name = $this->_addForm->getElement("name")->getValue();
            $task->description = $this->_addForm->getElement("desc")->getValue();
            $time = $this->_addForm->getElement("end_date")->getValue();
            if (!empty($time)) {
                $task->end_date = date("Y-m-d", strtotime($time));
            }
            $task->status = Task::STATUS_OPEN;
            $task->save();
            $message["success"] = 1;
            $message["message"] = "Task is saved successfully! Wait For Redirection!";
        } else {
            $message["errors"] = $this->_addForm->getErrors();
        }
        echo json_encode($message);
    }
    
    public  function completeAction()
    {
        $task = $this->_dataTable->find($this->getRequest()->getParam("id"))->current();
        $task->status = Task::STATUS_DONE;
        $task->end_date = date("Y-m-d H:i:s");
        $task->save();
        $this->_redirect("index");
    }
    
    public  function deleteAction()
    {
        $task = $this->_dataTable->find($this->getRequest()->getParam("id"))->current();
        $task->delete();
        $this->_redirect("index");
    }
    
    private function _newTaskForm()
    {
        $form = new Zend_Form();
        $form->setAction(APPLICATION_BASEURL_INDEX . "/index/save");
        $form->setMethod("POST");
        $form->setAttrib("id", "new-task-form");
        //Name
        $name = $form->createElement("text", "name");
        $name->setRequired(true)
            ->setAttrib("placeholder", "Short name that will remind you of the task!") //Some HTML 5 goodies!!!
            ->addValidator('StringLength', false, array(3, 250))
            ->setLabel("Name");
        //Desc
        $desc = $form->createElement("textarea", "desc");
        $desc->setLabel("Description")
            ->setAttrib("placeholder", "Enter something that will remind you the details of this task!");
        //End Date
        $endDate = $form->createElement("text", "end_date");
        $endDate->setLabel("End Date")
            ->setAttrib("placeholder", "28.10.2012")
            ->addValidator('Date', false, array("locale" => "tr"));            
        //Submit button
        $submit = $form->createElement("submit", "save-btn");
        $submit->setAttrib("class", "btn btn-primary")
            ->setLabel("Save It!");
        //Finally add them to the actual form...
        $form->addElements(array($name, $desc, $endDate, $submit));
        return $form;
    }
}

