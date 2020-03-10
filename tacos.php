<?php

if (!defined('_PS_VERSION_')) {
    exit;
}


class Tacos extends Module
{

    /**
     * @var array $hookList Hook list.
     */
    private $hookList = [
        'actionAdminControllerSetMedia'
    ];

    public function __construct()
    {
        $this->name = 'tacos';
        $this->version = '1.0.0';
        $this->tab = 'administration';
        $this->author = 'Olivier Wysocinski';
        $this->displayName = 'Tacos mdr';
        $this->description = 'Ceci est la description';
        $this->confirmUninstall = $this->l('Are u sure to niquer ta mère ?');

        $this->need_instance = 0;
        $this->bootstrap = true;

        $this->ps_version_compliancy = [
            'min' => '1.5',
            'max' => _PS_VERSION_
        ];

        parent::__construct();

        $this->shopGroupdId = (int)Shop::getContextShopGroupID();
        $this->shopId = (int)$this->context->shop->id;
        $this->langId = (int)$this->context->language->id;
        $this->langIso = pSQL($this->context->language->iso_code);
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
            //$this->shopGroupdId = (int)Shop::getContextShopGroupID();
        }

        return (
            (bool)parent::install() &&
            (bool)$this->_installTabList() &&
            (bool)$this->_registerHookList() &&
            (bool)$this->_installSql()
        );
    }


    protected function _installTabList()
    {
        $parentId = Tab::getIdFromClassName('AdminParentModules' . (version_compare(_PS_VERSION_, '1.7', '>=') ? 'Sf' : null));

        $tabList = ['Index' => $this->displayName];

        $i = 0;
        $languageList = Language::getLanguages(true);

        foreach ($tabList as $tabKey => $tabName) {
            $tabObject = new Tab();

            foreach ($languageList as $language) {
                $tabObject->name[(int)$language['id_lang']] = pSQL($tabName);
            }

            $tabObject->class_name = pSQL('Admin' . $tabKey . $this->name);
            $tabObject->module = pSQL($this->name);
            $tabObject->id_parent = (int)$parentId;
            $tabObject->position = Tab::getNewLastPosition((int)$parentId);
            $tabObject->active = ((int)$i === 0);
            $tabObject->add();
            $i++;
        }

        return true;
    }

    protected function _registerHookList(): bool
    {
        foreach ((array)$this->hookList as $hook) {
            if (!(bool)$this->registerHook($hook)) {
                return false;
            }
        }

        return true;
    }

    protected function _installSql(): bool
    {
        $queryList = [];

        $queryList[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . $this->name . '_testproduct` (
        `id_testproduct` INT(11) NOT NULL AUTO_INCREMENT,
        `product_id` INT(11) NOT NULL,
        `commentary` VARCHAR(255) NULL,
        `is_enabled` TINYINT(1) NOT NULL,
        PRIMARY KEY (`id_testproduct`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

        foreach ((array)$queryList as $query) {
            if (!(bool)Db::getInstance()->execute($query)) {
                return false;
            }
        }

        return true;
    }

    public function uninstall() :bool
    {
        return (
            (bool)parent::uninstall() &&
            (bool)$this->_uninstallTabList() &&
            (bool)$this->_unregisterHookList() &&
            (bool)$this->_uninstallSql()
        );
    }

    protected function _uninstallTabList() :bool {
        foreach (Tab::getCollectionFromModule($this->name) as $tab) {
            $tab->delete();
        }

        return true;
    }

    protected function _unregisterHookList() :bool{
        foreach((array)$this->hookList as $hook) {
            if(!(bool)$this->unregisterHook($hook)) {
                return false;
            }
        }

        return true;
    }

    protected function _uninstallSql() :bool {
        $tableList = [
            'testproduct'
        ];

        foreach ((array)$tableList as $table) {
            if(!(bool)Db::getInstance()->execute('DROP TABLE `'.pSQL(_DB_PREFIX_.$this->name.'_'.$table).'`')) {
                return false;
            }
        }

        return true;
    }

    public function getContent(){
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminIndex'.$this->name));
    }

    public function hookActionAdminControllerSetMedia($params) {
        if(Tools::getValue('controller') !== 'AdminIndex'.$this->name){
            return;
        }

        $this->context->controller->addCSS($this->_path.'views/css/back.css');
        $this->context->controller->addJS($this->_path.'views/js/back.js');
    }




}