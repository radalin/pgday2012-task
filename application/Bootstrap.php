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

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    //All the initializing functions should be protected and started with "_init"
    protected function _initConstants()
    {
        //These constants are used for cases where you are not on the root...
        define("APPLICATION_BASEURL", $this->_options["baseUrl"]);
        define("APPLICATION_BASEURL_INDEX", $this->_options["baseUrl"] . "/index.php");
    }
    
    protected function _initAutoLoader()
    {
        set_include_path(implode(PATH_SEPARATOR, array(
            APPLICATION_PATH . "/models",
            get_include_path(),
        )));
        spl_autoload_register(function($className) {
            //Write a very simple custom autoloader for models...
            if (Zend_Loader::isReadable("{$className}.php")) {
                require_once("{$className}.php");
            }
        });
    }
}

