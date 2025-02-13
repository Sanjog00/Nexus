<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'messageEncryptionKey' => getenv('MESSAGE_ENCRYPTION_KEY') ?: '123456789abcdefghijklmnopqrstuvwxyz',

];
