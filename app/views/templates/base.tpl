<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>Dziekanat</title>

    <meta name="description" content="Opis w Google"/>
    <meta name="keywords" content="słowa, kluczowe, wypisane, po, porzecinku"/>
</head>
<body>
<div id="top">
    <h1>Dziekanat</h1>
    <a href="main">Strona główna</a>
    <br />
</div>
{if !$msgs->isEmpty()}
    <ul>
        {foreach $msgs->getMessages() as $msg}
            <li>{$msg->text}</li>
        {/foreach}
    </ul>
{/if}
{block name=body}{/block}
</body>
<footer>
    <p>Malgorzata Cuber, 2020</p>
    <p>Wszelkie prawa zastrzezone</p>
</footer>
</html>
