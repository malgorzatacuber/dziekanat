{extends file='templates/base.tpl'}
{block name=body}
    <div id="container">
        {if $user}
            <div id="uzytkownik">
                <p>Witaj, {$user['name']} {$user['surname']}!</p>
            </div>
        {else}
            <div id="login">
                <a href="{$login_url}">Zaloguj się</a>
            </div>
        {/if}
    </div>
{/block}