{extends file='templates/base.tpl'}
{block name=body}
    <div id="container">
        {* jesli jest jakis uzytkownik - powitaj go i pokaz menu *}
        {if $user}
            <div id="uzytkownik">
                <p>Witaj, {$user['name']} {$user['surname']}!</p>
            </div>
            <div id="menu">
                <ul>
                    {foreach $menus as $menu}
                        {if $menu['show']}
                            <li>
                                <a href="{$menu['url']}">{$menu['text']}</a>
                            </li>
                        {/if}
                    {/foreach}
                </ul>
            </div>
        {/if}

        {* jesli mamy jakies komunikaty wyswietl je uzytkownikowi *}
        {if $statements}
            <h2>Komunikaty</h2>
            <ul>
                {foreach from=$statements item=statement}
                    <li>{$statement['message']}</li>
                {/foreach}
            </ul>
        {/if}
    </div>
{/block}