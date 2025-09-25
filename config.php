ILE: config.php
```php
<?php
// config.php
// Put your API key here and endpoint settings. Do NOT commit this file publicly.


return [
// Replace with your AI provider key (OpenAI or other). Example: 'sk-...'
'api_key' => 'ENTER_YOUR_API_KEY_HERE',
// For OpenAI (chat completions) you might use:
// 'api_url' => 'https://api.openai.com/v1/chat/completions'
'api_url' => 'https://api.openai.com/v1/chat/completions',


// Model to use (adjust if using other provider)
'model' => 'gpt-3.5-turbo',


// Other options
'max_tokens' => 800,
'temperature' => 0.7,
];
