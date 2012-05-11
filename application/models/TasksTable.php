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

class TasksTable extends Zend_Db_Table
{
    protected $_name = "tasks";
    protected $_rowClass = "Task";
    protected $_primary = "id";
   
    public function findAll()
    {
        $_select = $this->select();
        $_select->order("status");
        $_select->order("end_date");
        return $this->fetchAll($_select);
    }
    
    public function updateTaskStatuses()
    {
        //Example for running a hand written query on Zend_Db
        $query = "UPDATE tasks SET status = 'late' WHERE status = 'open' AND end_date IS NOT NULL AND end_date < 'now'";
        $this->getAdapter()->query($query);
    }
}