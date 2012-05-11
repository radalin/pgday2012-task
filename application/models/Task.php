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

class Task extends Zend_Db_Table_Row
{
    const STATUS_DONE = "done";
    const STATUS_LATE = "late";
    const STATUS_OPEN = "open";
    
    public function isDone()
    {
        return $this->status === "done";
    }
    
    public function getEndDate()
    {
        if (null === $this->end_date) {
            return "";
        }
        return date("d.m.Y", strtotime($this->end_date));
    }
    
    public function save()
    {
        if (null !== $this->id) {
            $this->_table->update($this->_data, $this->_table->getAdapter()->quoteInto("id = ?", $this->id));
            return $this->id;
        } else {
            $_id = $this->_table->insert($this->_data);
            if (is_integer($_id)) {
                $this->id = $_id;
                return $this->id;
            }
            return $_id;
        }
    }
    
    public function remove()
    {
        $this->_table->delete($table->getAdapter()->quoteInto('id = ?', $this->id));
    }
    
    public function getDiffToThisDay($date = "now")
    {
        $d1 = new DateTime("now");
        return $d1->diff(new DateTime($this->end_date));
    }
}