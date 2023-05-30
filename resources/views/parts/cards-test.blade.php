@if (Config::get('adyen.test_environment'))
    <style>
        .test-payment {
            background: white;
            border: 2px solid #eee;
            margin: 0;
            padding: 20px;
            position:absolute;
            right: 40px;
            top: 200px;
            z-index: 1050;
        }
        .test-payment ul {
            list-style: none;
            padding: 0;
        }
        .test-payment .active a {
            text-decoration: underline;
        }
    </style>
    <div class="test-payment">
        <h4>Test payment</h4>
        <ul>
            <li>
                <a href="#" data-card-number="6703 4444 4444 4449"  data-expiration-date="03/30" data-name="S.Hopper">
                    Bancontact
                </a>
            </li>
            <li>
                <a href="#" data-card-number="5558 8471 7035 2214" data-security-code="572" data-expiration-date="03/30" data-name="John Doe">
                    Mastercard ERROR
                </a>
            </li>
            <li>
                <a href="#" data-card-number="2223 0000 4841 0010" data-security-code="737" data-expiration-date="03/30" data-name="Johnny Be Good">
                    Mastercard SUCCESS
                </a>
            </li>
            <li>
                <a href="#" data-card-number="5212 3456 7890 1234" data-security-code="737" data-expiration-date="03/30" data-name="Johnny Be Good">
                    Mastercard 3D SECURE
                </a>
            </li>
            <li>
                <!-- @see https://www.getnewidentity.com/visa-credit-card.php -->
                <a href="#" data-card-number="4024 0071 4814 3471" data-security-code="483" data-expiration-date="03/30" data-name="John Good">
                    Visa ERROR
                </a>
            </li>
            <li>
                <!-- @see https://www.getnewidentity.com/visa-credit-card.php -->
                <a href="#" data-card-number="4111 1111 1111 1111" data-security-code="737" data-expiration-date="03/30" data-name="Johnny Be Good">
                    Visa SUCCESS
                </a>
            </li>
            <li>
                <!-- @see https://www.getnewidentity.com/visa-credit-card.php -->
                <a href="#" data-card-number="4212 3456 7890 1237" data-security-code="737" data-expiration-date="03/30" data-name="Johnny Be Good">
                    Visa 3D SECURE V1 <br />(username: user password: password)
                </a>
            </li>
            <li>
                <a href="#" data-card-number="4917 6100 0000 0000" data-security-code="737" data-expiration-date="03/30" data-name="Johnny Be Good">
                    Visa 3D SECURE V2 <br />(For native mobile integrations, use password: 1234 <br />For web and mobile browser integrations, use password: password)
                </a>
            </li>
            <li>
                <a href="#" data-iban="BE68 5390 0754 7034" data-iban-owner="John Doe">
                    SEPA ERROR
                </a>
            </li>
            <li>
                <a href="#" data-iban="NL13TEST0123456789" data-iban-owner="A. Klaassen">
                    SEPA SUCCESS
                </a>
            </li>
        </ul>
    </div>
@endif
