{extends file='templates/base.tpl'}
{block name=body}
    <div id="container">
        <form id="login" action="{$login_url}" method="POST">
            <label>
                Login:
                <input type="text" name="login" />
            </label>
            <br />
            <label>
                Haslo:
                <input type="password" name="password" />
            </label>
            <br />
            <input type="submit" value="Zaloguj" />
        </form>
    </div>
{/block}