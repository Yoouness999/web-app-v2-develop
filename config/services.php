<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/
	# facebook access
	"facebook" => array(
		'client_id' => "763884347071390",
		"client_secret" => "60ea7c69a2f920a58128796ed6e7dc1f",
		"redirect" => ROOT_URL.'/oauth/redirect/facebook'
	),

	# Braintree SandBox key
	/*"braintree" => array(
		'key' => "c9598xyh34bxc925",
		"secret" => "0bc3c55273c779587031d180e1cd9f99",
		"merchant_id" => "m9ytxb9kjzfcywxs",
		"cse_key" => "MIIBCgKCAQEA87JSCR/VZCrFQHuX+GTnunJx998ZV4ZKzfWA9VtMuo5x4AytzSNG4e9MDwIhob7yPhGLSGi7Dd4U3tTzVn9+P3rbhFVM/WqqQ1/0QQyUQnAX8/ypZ5iQxV/GwCjWwwBQlDyCccX4tdnd1ntSLHAEf8v2lzZ2sdEl1S+Rd42mRRib8MVvkGDwdnARwca1/BZy+qL0KHLXzP16hpUrgL9exvsGPY1k97nOwyTX0JP9udPEvq7x2wX5+dWmzvj0bIMnkCfo8TAkjVDBlRF7h6+Tic5cRlS3X3k2cJ92THqFVZpJciNaKm8ZfLljHnfASnrFwuw4Yi3bS3b+ioXhl4RRUwIDAQAB"
	),*/

	"braintree_sandbox" => array(
		'key' => "tms6jrjpvd7gsx33",
		"secret" => "ead2f29ffc7275440de3b22554a86928",
		"merchant_id" => "xvnw6dfnv4fqn22m",
		"cse_key" => "MIIBCgKCAQEA0XGS3YhxwbNgG6jQZnWTF4sOdLw8QxvTViPbub/v61ZrBwycpejtXrlc9q//zauseX11sfPeSrhObAIp0f4SCK81WMd6yRxDilmdxxO2Kzzb6U0PkI6KqbDyVY/0gEGOnFxZLFX1VzloP69KxoWgY+bRfgYobLr+aYlW/GmEU74KNzmSf0cq2RdCj4nQhaBr/kiPPwo4MgOyopuewm5JOU3ylRhmQXH0BVvC+G4okIRysfbIDF5Rf2oheJSHmP+chR1BM7V+e4+3vTWs8n8ljyo2Ui9pU4kbXnzwXM5wVq2W8uw+wY7XMI1uX8bWEk2HG0LEvzFCXubLb9gsLFxjhQIDAQAB"
	),

	"braintree" => array(
		'key' => "tms6jrjpvd7gsx33",
		"secret" => "ead2f29ffc7275440de3b22554a86928",
		"merchant_id" => "xvnw6dfnv4fqn22m",
		"cse_key" => "MIIBCgKCAQEA0XGS3YhxwbNgG6jQZnWTF4sOdLw8QxvTViPbub/v61ZrBwycpejtXrlc9q//zauseX11sfPeSrhObAIp0f4SCK81WMd6yRxDilmdxxO2Kzzb6U0PkI6KqbDyVY/0gEGOnFxZLFX1VzloP69KxoWgY+bRfgYobLr+aYlW/GmEU74KNzmSf0cq2RdCj4nQhaBr/kiPPwo4MgOyopuewm5JOU3ylRhmQXH0BVvC+G4okIRysfbIDF5Rf2oheJSHmP+chR1BM7V+e4+3vTWs8n8ljyo2Ui9pU4kbXnzwXM5wVq2W8uw+wY7XMI1uX8bWEk2HG0LEvzFCXubLb9gsLFxjhQIDAQAB"
	),

];