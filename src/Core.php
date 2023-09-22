<?php

namespace Vpos;

class Core
{
    const PAGE_NAME_HOMEPAGE = 'Home';
    const PAGE_NAME_RESULT = 'Result';
    const PAGE_NAME_NOT_FOUND = 'NotFound';
    const PAGE_NAME_REVIEW = 'Review';
    const ERROR_CODES = [
        '01' => 'Referral - call bank for manual approval.',
        '02' => 'Fake Approval, but should not be used in a VPOS system, check withyour bank.',
        '03' => 'Invalid merchant or service provider.',
        '04' => 'Pick-up card. Card holders who have canceled their card lost or if the message is about.',
        '05' => 'Do not honour Why the denied message bank by calling the cardholder should ask that.',
        '06' => 'Error (found only in file update responses).',
        '07' => 'Pick up card, special condition. Card holders can receive detailed information by calling the bank.',
        '08' => 'Fake Approval, but should not be used in a VPOS system, check with your bank.',
        '11' => 'Fake Approved (VIP), but should not be used in a VPOS system, check with your bank.',
        '12' => 'Transaction is not valid. Sent transaction can\'t be defined by the bank. Report to the Support Desk about',
        '13' => 'Invalid amount. The error is not receiving the amount sent in the correct format.',
        '14' => 'Invalid account number. Merchant or the wrong terminal number can\'t be defined.',
        '15' => 'No such issuer. This is defined as the bank does not provide a credit card.',
        '19' => 'Reenter, try again. Report to the Support Desk about the error.',
        '20' => 'Invalid amount. Invalid amount.',
        '21' => 'Unable to back out transaction. Report to the Support Desk about the error.',
        '25' => 'Unable to locate record on file. Report to the Support Desk about the error',
        '26' => 'Transaction not found This transaction not found. Report to the Support Desk about the error.',
        '27' => 'Bank decline Report to the Support Desk about the error.',
        '28' => 'Original is denied Report to the Support Desk about the error.',
        '29' => 'Original not found Report to the Support Desk about the error.',
        '30' => 'Format error (switch generated) Report to the Support Desk about the error.',
        '32' => 'Referral (General) Report to the Support Desk about the error.',
        '33' => 'Expired card, pick-up Retrieving message is denied by the bank for credit card has expired.',
        '34' => 'Suspected fraud, pick-up With a suspected fraud then pick-up card by the bank.',
        '36' => 'Restricted card, pick-up Card holders can receive detailed information by calling the bank.',
        '37' => 'Pick up card. Issuer wants card returned.',
        '38' => 'Allowable PIN tries exceeded, pick- up. Report to the Support Desk about the error.',
        '41' => 'Lost card, Pick-up Credit card could be canceled. Cardholder should try the transaction with new card.',
        '43' => 'Stolen card, pick-up Credit card could be canceled. Cardholder should try the transaction with new card.',
        '51' => 'Insufficient funds Card limit is insufficient.',
        '52' => 'o checking account Report to the Support Desk about the error.',
        '53' => 'No savings account Report to the Support Desk about the error.',
        '54' => 'Expired card. Cardholder should try the transaction with new card.',
        '55' => 'Incorrect PIN Report to the Support Desk about the error.',
        '56' => 'No card record Report to the Support Desk about the error.',
        '57' => 'Transaction not permitted to cardholder Debit card or transaction not permitted.',
        '58' => 'Transaction not permitted to terminal. The virtual POS Transaction not permitted.',
        '59' => 'Fraud Card holders can receive detailed information by calling the Support Desk.',
        '61' => 'Activity amount limit exceeded Belong to the virtual POS cancel the limit was exceeded.',
        '62' => 'Restricted card Report to the Support Desk about the error.',
        '63' => 'Security violation Report to the Support Desk about the error.',
        '65' => 'Activity limit exceeded Report to the Support Desk about the error.',
        '66' => 'System error.',
        '75' => 'Allowable number of PIN tries exceeded',
        '76' => 'Key synchronization error Report to the Support Desk about the error.',
        '77' => 'Inconsistent data Report to the Support Desk about the error.',
        '80' => 'Date is not valid Credit card information is checked and should be tried again.',
        '81' => 'Encryption Error Report to the Support Desk about the error.',
        '82' => 'CVV Failure or CVV Value supplied is not valid',
        '83' => 'Cannot verify PIN Report to the Support Desk about the error.',
        '84' => 'Invalid CVV. Invalid CVV. Please check CVV number and try again.',
        '85' => 'Declined (General) Report to the Support Desk about the error.',
        '91' => 'Issuer or switch is inoperative There is no response from the bank. Please contact the support desk.',
        '92' => 'Timeout, reversal is trying Response get late from the bank. Transaction is canceling now.',
        '93' => 'Violation, cannot complete (installment, loyalty)',
        '96' => 'System malfunction Report to the Support Desk about the error.',
        '98' => 'Duplicate Reversal Report to the Support Desk about the error.',
        '99' => 'Transaction Unsuccessful.'
    ];

    public $pageName;

    function __construct()
    {
        $this->pageName =
            array_key_exists('ProcReturnCode', $_POST) ||
            array_key_exists('MaskedPan', $_POST) ||
            array_key_exists('Response', $_POST) ?
                self::PAGE_NAME_RESULT :
                self::pageParameter();
    }

    function getPageName()
    {
        return $this->pageName;
    }

    function setPageName($newName)
    {
        $this->pageName = $newName;
    }

    function getRelativePagePath()
    {
        return '../pages/' . $this->getPageName() . '.php';
    }

    function getAbsolutePagePath()
    {
        return __DIR__ . '/' . $this->getRelativePagePath();
    }

    function isPageExists()
    {
        return file_exists($this->getAbsolutePagePath());
    }

    static function pageParameter()
    {
        return isset($_GET['p']) ? $_GET['p'] : self::PAGE_NAME_HOMEPAGE;
    }

    function isHashValid()
    {
        $hash = '';
        $arrayKeys = array_keys($_POST);
        natcasesort($arrayKeys);

        foreach ($arrayKeys as $param){
            $paramValue = $_POST[$param];
            $escapedParamValue = str_replace('', '\\|', str_replace('\\', '\\\\', $paramValue));

            if(strtolower($param) != 'hash' && strtolower($param) != 'encoding' )	{
                $hash .= $escapedParamValue . '|';
            }
        }

        $escapedStoreKey = str_replace('|', '\\|', str_replace('\\', '\\\\', env('STORE_KEY')));
        $hash .= $escapedStoreKey;

        $calculatedHashValue = hash('sha512', $hash);
        $actualHash = base64_encode (pack('H*',$calculatedHashValue));

        return $_POST['HASH'] == $actualHash;
    }

    private function loadPageData()
    {
        if (
            !array_key_exists('p', $_GET) &&
            !(
                array_key_exists('ProcReturnCode', $_POST) ||
                array_key_exists('Response', $_POST) ||
                array_key_exists('MaskedPan', $_POST)
            )
        ) return null;

        switch ($this->getPageName()) {
            case 'Form':
                $type = new \Vpos\Type();
                $parameters = $type->getParameters();
                $action = $type->getAction();

                $data = [
                    'Instalment' => '',
                    'currency' => env('CURRENCY'),
                    'oid' => 'FO' . rand(1000, 10000),
                    'amount' => '9.95',
                    'lang' => env('LANG_EN'),
                    'email' => env('COMPANY_EMAIL'),
                    'firmaadi' => env('COMPANY_NAME'),
                    'hashAlgorithm' => 'ver3',
                    'refreshtime' => '10'
                ];

                if ($type->getName() === 'PayHosting') {
                    $data['pan'] = env('CARD_1_PAN');
                    $data['Ecom_Payment_Card_ExpDate_Year'] = '2025';
                    $data['Ecom_Payment_Card_ExpDate_Month'] = '12';
                }

                return [
                    'dummyData' => $data,
                    'parameters' => $parameters,
                    'action' => $action
                ];
            case 'Review':
                $random = microtime();

                $fields = $_POST['vpos']['fields'];

                $fields['rnd'] = $random;

                $fields = array_filter($fields, function ($v, $k) {
                    return $k == 'Instalment' || $v !== '';
                }, ARRAY_FILTER_USE_BOTH);

                ksort($fields,  SORT_STRING | SORT_FLAG_CASE);
                $fields['storeKey'] = env('STORE_KEY');
                $keys[] = 'storeKey';

                $hash = base64_encode(
                    pack(
                        'H*',
                        hash('sha512', implode('|', $fields))
                    )
                );
                return [
                    'random' => $random,
                    'hash' => $hash
                ];
            case 'Result':
                $hashResult = $this->isHashValid();
                $bankErrorMessage = array_key_exists('ErrMsg', $_POST) &&
                !empty($_POST['ErrMsg']) ? $_POST['ErrMsg']  : '';

                $bankErrorMessage .= array_key_exists('mdErrorMsg', $_POST) &&
                    !empty($_POST['mdErrorMsg']) ? $_POST['mdErrorMsg']  : '';

                if(!$hashResult) $bankErrorMessage .= 'Unauthorized attempt.';

                return [
                    '3DSucceed' =>
                        $hashResult &&
                        array_key_exists('mdStatus', $_POST) &&
                        in_array($_POST["mdStatus"], ['1', '2', '3', '4']),
                    '3DFailed' =>
                        array_key_exists('mdStatus', $_POST) &&
                        $_POST["mdStatus"] == '0',
                    'success' =>
                        $hashResult &&
                        array_key_exists('Response', $_POST) &&
                        $_POST["Response"] == "Approved",
                    'errorMessage' =>
                        array_key_exists('ProcReturnCode', $_POST) &&
                        array_key_exists($_POST['ProcReturnCode'], self::ERROR_CODES) ?
                            self::ERROR_CODES[$_POST['ProcReturnCode']] . ' ' . $bankErrorMessage :
                            ' ' . $bankErrorMessage
                ];
            default:
                return [];
        }
    }

    function load()
    {
        if (
            !$this->isPageExists() or
            (
                isset($_GET['p']) and
                $_GET['p'] === self::PAGE_NAME_REVIEW and
                !isset($_POST['vpos'])
            )
        ) {
            http_response_code(404);

            $this->setPageName(self::PAGE_NAME_NOT_FOUND);
        }

        $pageData = $this->loadPageData();
        include_once $this->getAbsolutePagePath();
    }
}