<?php

class AdminIndextacosController extends ModuleAdminController {
    public function __construct()
    {
        $this->bootstrap = true;
        $this->context = Context::getContext();
        parent::__construct();
    }

    public function renderList() {
        $product_id = null;
        $commentary = null;
        $is_enabled = false;

        if(Tools::isSubmit('testform')) {
            $product_id = Tools::getValue('product_id');
            $commentary = Tools::getValue('commentary');
            $is_enabled = Tools::getValue('is_enabled');
        }

        $this->context->smarty->assign([
            'controllerLink' => $this->context->link->getAdminLink(Tools::getValue('controller')),
            'product_id' => $product_id,
            'commentary' => $commentary,
            'is_enabled' => $is_enabled,
        ]);

        return $this->module->display(_PS_MODULE_DIR_.$this->module->name, 'views/templates/admin/base.tpl');
    }
}