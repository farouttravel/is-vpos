<?php

namespace Vpos;

class Core
{
    const PAGE_NAME_HOMEPAGE = 'Home';
    const PAGE_NAME_RESULT = 'Result';
    const PAGE_NAME_NOT_FOUND = 'NotFound';
    const PAGE_NAME_REVIEW = 'Review';

    public $pageName;

    function __construct()
    {
        $this->pageName = isset($_POST["Response"]) ? self::PAGE_NAME_RESULT : self::pageParameter();
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

    private function loadPageData()
    {
        if (!array_key_exists('p', $_GET)) return null;

        switch ($_GET['p']) {
            case 'Form':
                $type = new \Vpos\Type();
                $parameters = $type->getParameters();
                $action = $type->getAction();

                $data = [
                    'taksit' => '',
                    'currency' => env('CURRENCY'),
                    'oid' => 'FO' . rand(1000, 10000),
                    'amount' => '9.95',
                    'lang' => env('LANG_EN'),
                    'email' => env('COMPANY_EMAIL'),
                    'firmaadi' => env('COMPANY_NAME'),
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

                $hashStr =
                    $_POST['vpos']['fields']['clientid'] .
                    $_POST['vpos']['fields']['oid'] .
                    $_POST['vpos']['fields']['amount'] .
                    $_POST['vpos']['fields']['okUrl'] .
                    $_POST['vpos']['fields']['failUrl'] .
                    $_POST['vpos']['fields']['islemtipi'] .
                    $_POST['vpos']['fields']['taksit'] .
                    $random .
                    env('STORE_KEY');
                $hash = base64_encode(pack('H*', sha1($hashStr)));
                return [
                    'random' => $random,
                    'hash' => $hash
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