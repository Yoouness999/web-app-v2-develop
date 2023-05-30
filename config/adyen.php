<?php

return [
	'username' => env('ADYEN_USERNAME'),
	'password' => env('ADYEN_PASSWORD'),
	'test_environment' => env('ADYEN_TEST_ENVIRONMENT'),
	'application_name' => env('ADYEN_APPLICATION_NAME'),
	'merchant_account' => env('ADYEN_MERCHANT_ACCOUNT'),
	'client_encryption_public_key' => env('ADYEN_CLIENT_ENCRYPTION_PULIC_KEY'),
];