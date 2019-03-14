<?php
/*  � 2013 eBay Inc., All Rights Reserved */
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */
    //show all errors
    error_reporting(E_ALL);

    // these keys can be obtained by registering at http://developer.ebay.com

    $production         = true;   // toggle to true if going against production
    $compatabilityLevel = 717;    // eBay API version

    if ($production == false) {

        $devID  = '682d591a-82ae-41d5-a86b-4cbca157033c';   // these prod keys are different from sandbox keys
        $appID  = 'sarbrind-1wayitso-SBX-45d8a3c47-868c1fce';
        $certID = 'SBX-5d8a3c470219-01b1-40f3-8beb-b187';
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
        //the token representing the eBay user to assign the call with
        $userToken = 'AgAAAA**AQAAAA**aAAAAA**W7nYWQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4GnCZiHpA6dj6x9nY+seQ**dlkEAA**AAMAAA**WCWBVD/IGt6ROGsZWKOfqqeS8qDr6GmNPHygfi4+Q17WaWm6qI06PxVI0Zjmd6f1v3QpRM4TkgwTomzq72+nkjBtV/ovOyuZbbX1scIOUz8W4djD9PjTVdSSStZug9JnNLMCGJSz8+Lfzl7A4uF6w/TNnCQ4mFUn7+cwfteiRfT9n2Cblyox6Oe784FmnwSdvW1781VksS2SlZGTHHcjtr1u8Aj9RUvEM9WT0zFB7OoJn0nC6gQDYFw1EkiAFLuzywm9YoE45TYLa9FugJfegc/yK6PJ/aiNYH7pPXXoQ0dk6ROPvrPLApQ6Jza0EjiSFEYRaRAIERQtD1SjeR3935x94124gnxaU/baJhxo8SsFbyqWcGWv80PXBNGx8SOBajkjZs1/A7ipkCNLQm7/y8kPbgIPwGgxniu6fRZXY1EGGNDoZBxHawiN6QzyKYP9DDJ1j1S9SHNMpEO/AiZDcchNswj1quo99XlUvA68/V6yn3TP91lMb39Xg0Il0/jsuHT4Bm9n/ryu7srepxlI6yyoB3XEQ5sgJEJXpoOctW0Ib7YQ7Jo+NBooTcgm5GP62xOioQbr+8cjV5FjZc6Xj/E4C5K/BbYPP6tMc6SLLeeyDy6nau6izdGsQ8ueznHVpk6T2s9lj5PItxcny7vY6+8bmH5v5TycdqMBu0YbfF27u+alM1fB4ksziYsV/mUmbNbW2rY6lDZvHJmrah4wG9Wop8uj7eetacDoDyWRiVvNNquGVAGD8N6w5hg3XT+e';
    } else {
        /*
        SandBox keys
        // sandbox (test) environment
        $devID  = '682d591a-82ae-41d5-a86b-4cbca157033c';   // these prod keys are different from sandbox keys
        $appID  = 'sarbrind-1wayitso-SBX-45d8a3c47-868c1fce';
        $certID = 'SBX-5d8a3c470219-01b1-40f3-8beb-b187';
          */

        /** Live keys start here*/

        $devID  = '682d591a-82ae-41d5-a86b-4cbca157033c';   // these prod keys are different from sandbox keys
        $appID  = 'preetsin-1wayitso-PRD-e134e8f72-1af3a723';
        $certID = 'PRD-134e8f723944-f33e-4b57-8a86-f233';

        /*   Live Keys ends here    **/


        //set the Server to use (Sandbox or Production)
        //$serverUrl = 'https://api.sandbox.ebay.com/ws/api.dll';
        $serverUrl = 'https://api.ebay.com/ws/api.dll';

        // the token representing the eBay user to assign the call with
        // this token is a long string - don't insert new lines - different from prod token
       /*$userToken = 'AgAAAA**AQAAAA**aAAAAA**VQnbWQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4GnCZiHpA6dj6x9nY+seQ**dlkEAA**AAMAAA**WCWBVD/IGt6ROGsZWKOfqqeS8qDr6GmNPHygfi4+Q17WaWm6qI06PxVI0Zjmd6f1v3QpRM4TkgwTomzq72+nkjBtV/ovOyuZbbX1scIOUz8W4djD9PjTVdSSStZug9JnNLMCGJSz8+Lfzl7A4uF6w/TNnCQ4mFUn7+cwfteiRfT9n2Cblyox6Oe784FmnwSdvW1781VksS2SlZGTHHcjtr1u8Aj9RUvEM9WT0zFB7OoJn0nC6gQDYFw1EkiAFLuzywm9YoE45TYLa9FugJfegc/yK6PJ/aiNYH7pPXXoQ0dk6ROPvrPLApQ6Jza0EjiSFEYRaRAIERQtD1SjeR3935x94124gnxaU/baJhxo8SsFbyqWcGWv80PXBNGx8SOBajkjZs1/A7ipkCNLQm7/y8kPbgIPwGgxniu6fRZXY1EGGNDoZBxHawiN6QzyKYP9DDJ1j1S9SHNMpEO/AiZDcchNswj1quo99XlUvA68/V6yn3TP91lMb39Xg0Il0/jsuHT4Bm9n/ryu7srepxlI6yyoB3XEQ5sgJEJXpoOctW0Ib7YQ7Jo+NBooTcgm5GP62xOioQbr+8cjV5FjZc6Xj/E4C5K/BbYPP6tMc6SLLeeyDy6nau6izdGsQ8ueznHVpk6T2s9lj5PItxcny7vY6+8bmH5v5TycdqMBu0YbfF27u+alM1fB4ksziYsV/mUmbNbW2rY6lDZvHJmrah4wG9Wop8uj7eetacDoDyWRiVvNNquGVAGD8N6w5hg3XT+e';
       */

       /****

       new Token

       AgAAAA**AQAAAA**aAAAAA**jydnWg**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEkoKnAZSEowqdj6x9nY+seQ**iQUEAA**AAMAAA**krugyYp9qFVm0xwn5Frxq/suRLC10tvds+j4Txt+GBszUcynuksHRHTq5uvpG0C/gh41ZIzcUDzQZNK1v6CKSszOMRaQWw6fd6aq2VsllJFcNYcFtWLvrelIFsGzSAnLUwun8CKBq6YB497rVNPJARKX0+DEBr5WS/CY9uqlgNC9bPN+d3XaZomsUVCQmmDnQC35K8341ynYt14wfJPFPvuU6czBWGFKpEAMclsdnMYHbNufw7JTmQ321JHbvmjcKocXskd7Sjn5E/6TSHRBBI4vCEKK6CXa46Y3BvlMQM5oG8uyHgonGyYtCVklA9ErTp7rvBg1dUe894E5dHvbjQygn2apddPr2FEHqRfddY++82mX3YhiYzQQf4sbCBsV9VVMUne4vah1MjMURIIBhBfGE790DKB22YhasO1QJnuDmkNgVOVHfBurB+sIfG3fxNLsOi28VAQqLHbAaOVePzP/Lworv0VtkWmHD75D+m02Uf3PxlQW6p4Ra1ad/IZ77mqSonL9SKuRbSaRiYIW586SxjUNFKvkrn3J7omnVZUodwrWij3UA/tGOAVOzOETxb6mZnQSieRHcuJJXEcK7BPxhiWk2Y2nDZI0a9SkDeFbixgkA9ncn+t9FRHXvJKjJKzXYbZLLIgHUlWt131oNk7aMcaOBsWo/xs7PY52mmOtpvKedjm/E9DS6EUmWUlmSxcgXo8MH37ZRUOklsBovQFF3KaUODRGfltviw3IFAb1SoruTSXmzdUkkypIGrKB

       *****/
       $userToken = 'AgAAAA**AQAAAA**aAAAAA**eccXWg**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEkoKnAZSEowqdj6x9nY+seQ**iQUEAA**AAMAAA**krugyYp9qFVm0xwn5Frxq/suRLC10tvds+j4Txt+GBszUcynuksHRHTq5uvpG0C/gh41ZIzcUDzQZNK1v6CKSszOMRaQWw6fd6aq2VsllJFcNYcFtWLvrelIFsGzSAnLUwun8CKBq6YB497rVNPJARKX0+DEBr5WS/CY9uqlgNC9bPN+d3XaZomsUVCQmmDnQC35K8341ynYt14wfJPFPvuU6czBWGFKpEAMclsdnMYHbNufw7JTmQ321JHbvmjcKocXskd7Sjn5E/6TSHRBBI4vCEKK6CXa46Y3BvlMQM5oG8uyHgonGyYtCVklA9ErTp7rvBg1dUe894E5dHvbjQygn2apddPr2FEHqRfddY++82mX3YhiYzQQf4sbCBsV9VVMUne4vah1MjMURIIBhBfGE790DKB22YhasO1QJnuDmkNgVOVHfBurB+sIfG3fxNLsOi28VAQqLHbAaOVePzP/Lworv0VtkWmHD75D+m02Uf3PxlQW6p4Ra1ad/IZ77mqSonL9SKuRbSaRiYIW586SxjUNFKvkrn3J7omnVZUodwrWij3UA/tGOAVOzOETxb6mZnQSieRHcuJJXEcK7BPxhiWk2Y2nDZI0a9SkDeFbixgkA9ncn+t9FRHXvJKjJKzXYbZLLIgHUlWt131oNk7aMcaOBsWo/xs7PY52mmOtpvKedjm/E9DS6EUmWUlmSxcgXo8MH37ZRUOklsBovQFF3KaUODRGfltviw3IFAb1SoruTSXmzdUkkypIGrKB';
    }


?>
