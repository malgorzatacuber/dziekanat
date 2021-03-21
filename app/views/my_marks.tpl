{extends file='templates/base.tpl'}
{block name=body}
    <div id="container">
        {* jesli mamy jakies oceny wyswietl tabelke z nimi *}
        {if $marks}
        <table>
            <tr>
                <th>ID</th>
                <th>Ocena</th>
                <th>Prowadzacy</th>
                <th>Dodano</th>
            </tr>
            {foreach from=$marks item=mark}
            <tr>
                <td>{$mark['id']}</td>
                <td>{$mark['mark']}</td>
                <td>{$mark['surname']} {$mark['name']}</td>
                <td>{$mark['added_at']}</td>
            </tr>
            {/foreach}
        </table>
        {/if}
    </div>
{/block}