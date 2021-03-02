{extends file='templates/base.tpl'}
{block name=body}
    <div id="container">
        {* jesli mamy jakies oceny wyswietl tabelke z nimi *}
        {if $marks}
        <table>
            <tr>
                <th>ID</th>
                <th>Ocena</th>
                <th>Imie ucznia</th>
                <th>Nazwisko ucznia</th>
                <th>Dodano</th>
            </tr>
            {foreach from=$marks item=mark}
            <tr>
                <td>{$mark['id']}</td>
                <td>{$mark['mark']}</td>
                <td>{$mark['name']}</td>
                <td>{$mark['surname']}</td>
                <td>{$mark['added_at']}</td>
            </tr>
            {/foreach}
        </table>
        {/if}
        <div id="dowawanie-oceny">
            <p>Dodaj nowa ocene:</p>
            <form method="post" action="{$marks_url}">
                <label>
                    Ocena
                    <input type="number" name="mark">
                </label> <br>
                <label>
                    Uczen
                    <select name="student_id">
                        {foreach from=$students item=student}
                            <option value="{$student['id']}">{$student['name']} {$student['surname']}</option>
                        {/foreach}
                    </select>
                </label> <br>
                <input type="submit" value="Dodaj">
            </form>
        </div>

    </div>
{/block}