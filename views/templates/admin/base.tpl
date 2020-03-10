<main
        id="module-test"
        class="{if version_compare($smarty.const._PS_VERSION_,'1.6','<')}bootstrap{/if}"
>
    <form
            method="post"
            action="{$controllerLink}"
            class="panel">
        <input type="hidden" name="testform" value="1">

        <header class="panel-header">
            <h3>{l s='Configuration' mod='tacos'}</h3>
        </header>

        <div class="panel-body">
            {if $errors|@count gt 0 }
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="alert-danger alert">
                            <h4 >{l s='Erreur' mod='tacos'}</h4>
                            {section name=error loop=$errors}
                                <li>{$errors[error]}</li>
                            {/section}
                        </ul>
                    </div>
                </div>
            {/if}
            <div class="row">
                <div class="col-lg-12">
                    <h4>
                        {l s='ID du Produit' mod='tacos'}
                    </h4>

                    <div class="form-group">
                        <div class="margin-form">
                            <input type="text" name="product_id" id="product_id" value="{$product_id|escape:'htmlall':'UTF-8'}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h4>
                        {l s='Commentaire' mod='tacos'}
                    </h4>

                    <div class="form-group">
                        <div class="margin-form">
                            <input maxlength="255" type="text" name="commentary" id="commentary" value="{$commentary|escape:'htmlall':'UTF-8'}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h4>
                        {l s='Est il actif ?' mod='tacos'}
                    </h4>
                    <div class="form-group">
                        <div class="margin-form">
                            <span class="switch prestashop-switch">
                                <input type="radio" name="is_enabled" id="is_enabled_1" value="1" {if $is_enabled}checked="checked"{/if}>
                                <label for="is_enabled_1">{l s='Enabled' mod='tacos'}</label>

                                 <input type="radio" name="is_enabled" id="is_enabled_0" value="0" {if !$is_enabled}checked="checked"{/if}>
                                <label for="is_enabled_0">{l s='Disabled' mod='tacos'}</label>

                                <a class="slide-button btn"></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="panel-footer">
            <input type="submit" value="{l s='Save' mod='tacos'}">
        </footer>
    </form>
</main>