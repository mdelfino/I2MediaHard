<?php

class Infortis_ThemeAdmin_Model_ThemeAdmin extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('themeadmin/themeadmin');
    }
}