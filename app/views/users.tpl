{extends file='templates/base.tpl'}
{block name=body}
    <div id="container">
        {* jesli mamy jakichs uzytkownikow wyswietl tabelke z nimi *}
        {if $users}
        <table>
            <tr>
                <th>ID</th>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Login</th>
                <th>Rola</th>
            </tr>
            {foreach from=$users item=user}
            <tr>
                <td>{$user['id']}</td>
                <td>{$user['name']}</td>
                <td>{$user['surname']}</td>
                <td>{$user['login']}</td>
                <td>{$user['role']}</td>
            </tr>
            {/foreach}
        </table>
        {/if}
        <div id="dowawanie-uzytkownika">
            <p>Dodaj nowego użytkownika:</p>
            <form method="post" action="{$register_url}">
                <label>
                    Imię
                    <input type="text" name="name">
                </label> <br>
                <label>
                    Nazwisko
                    <input type="text" name="surname">
                </label> <br>
                <label>
                    Login
                    <input type="text" name="login">
                </label> <br>
                <label>
                    Hasło
                    <input type="text" name="password">
                </label> <br>
                <label>
                    Rola
                    <select name="role">
                        <option value="uczen">Uczen</option>
                        <option value="prowadzacy">Prowadzacy</option>
                        <option value="dziekanat">Dziekanat</option>
                        <option value="admin">Admin</option>
                    </select>
                </label> <br>
                <input type="submit" value="Dodaj">
            </form>
        </div>

    </div>
{/block}