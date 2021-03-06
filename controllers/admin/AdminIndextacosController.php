<?php

class AdminIndextacosController extends ModuleAdminController {
    public function __construct()
    {
        $this->bootstrap = true;
        $this->context = Context::getContext();
        parent::__construct();
    }

    public function renderList() {
        $errors = [];

        $product_id = null;
        $commentary = null;
        $is_enabled = false;

        if(Tools::isSubmit('testform')) {
            $product_id = Tools::getValue('product_id');
            $commentary = Tools::getValue('commentary');
            $is_enabled = Tools::getValue('is_enabled');

            if(!Validate::isInt($product_id)) {
                $errors[] = 'L\'id du produit est invalide';
                $product_id = null;
            }

            if(!Validate::isBool($is_enabled)) {
                $errors[] = 'L\'état du produit est invalide';
                $is_enabled = false;
            }
        }

        $this->context->smarty->assign([
            'controllerLink' => $this->context->link->getAdminLink(Tools::getValue('controller')),
            'errors' => $errors,
            'product_id' => $product_id,
            'commentary' => $commentary,
            'is_enabled' => (bool)$is_enabled,
        ]);

        return $this->module->display(_PS_MODULE_DIR_.$this->module->name, 'views/templates/admin/base.tpl');
    }
}