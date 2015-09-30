<?php

require  'boot.php';

?>

per attivare il webhook : <br/>
<?=$curlCommand1;?> <br/>

<a href="https://api.telegram.org/bot<?=$token;?>/setWebhook?url=<?=$urlWebhooks;?>"> attiva WebHooks </a> <br/>
<a href="https://api.telegram.org/bot<?=$token;?>/setWebhook?url="> disattiva WebHooks </a> <br/>
<a href="https://api.telegram.org/bot<?=$token;?>/getUpdates"> getUpdate WebHooks </a> <br/>
<a href="https://api.telegram.org/bot<?=$token;?>/getMe"> getMe </a> <br/>
