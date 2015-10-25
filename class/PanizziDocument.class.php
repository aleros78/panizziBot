<?php
class PanizziDocument extends DOMDocument {
    const CARD_REQUEST_URL = 'http://cataloghi.comune.re.it/Cataloghi/html/index.php';

    private $sCardNumber;

    public function __construct ($sCardNumber) {
        $this->sCardNumber = $sCardNumber;
    }

    /**
    *   Retrieve the card situation in details.
    *
    *   @return array The "libraries" key contains an array with PanizziLibrary objects,
    *                 the "books" key contains a key/value array with in key the library
    *                 name and as value an array of PanizziBook objects.
    */
    public function getCardSituation () {
        if (function_exists('curl_version')) {
            $sResponse = $this->getCardSituationCurl();
        }
        else {
            $sResponse = $this->getCardSituationWithoutCurl();
        }

        $aSituation = $this->parseCardSituation($sResponse);

        return array(
            'libraries' => $aSituation['libraries'],
            'books' => $aSituation['books']
        );
    }

    private function parseCardSituation ($sResponse) {
        $this->loadHTML($sResponse);

        require_once(dirname(__FILE__) . '/PanizziParser.class.php');
        $hXPath = new PanizziParser($this);
        $aNodesList = $hXPath->queryCardNumber();
        $hCarNum = $aNodesList->item(0);
        if (!preg_match('/Tessera: \d*/', $hCarNum->nodeValue)) {
            throw new Exception("Tessera non presente");
        }
        $hNodesList = $hXPath->queryLibrariesName();
        require_once(dirname(__FILE__) . '/PanizziLibrary.class.php');
        require_once(dirname(__FILE__) . '/PanizziBook.class.php');
        $aLibraries = array();
        $aMyBooks = array();
        foreach ($hNodesList as $hNode) {
            $hLibrary = new PanizziLibrary($hNode);
            $aLibraries[] = $hLibrary;
            $hBookNodes = $hXPath->queryLibraryBooks($hLibrary);
            foreach ($hBookNodes as $hBookNode) {
                $hBook = new PanizziBook();
                $hBook->loadFromDOMNode($hXPath->queryBookData($hBookNode));
                $aMyBooks[$hLibrary->name][] = $hBook;
            }
        }

        return array(
            'libraries' => $aLibraries,
            'books' => $aMyBooks
        );
    }

    private function getCardSituationCurl () {
        $hCurl = curl_init(self::CARD_REQUEST_URL);
        curl_setopt($hCurl, CURLOPT_POSTFIELDS, http_build_query(array(
            'num_tess' => $this->sCardNumber,
            'image.x'  => 12,
            'image.y'  => 11
        )));
        curl_setopt($hCurl, CURLOPT_POST, true);
        curl_setopt($hCurl, CURLOPT_RETURNTRANSFER, true);
        $sResponse = curl_exec($hCurl);
        curl_close($hCurl);

        return $sResponse;
    }

    private function getCardSituationWithoutCurl () {
        $sData = http_build_query(array(
            'num_tess' => $this->sCardNumber,
            'image.x'  => 12,
            'image.y'  => 11
        ));
        $aOpts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $sData
            )
        );
        $rContext  = stream_context_create($aOpts);
        $sResponse = file_get_contents(self::CARD_REQUEST_URL, false, $rContext);

        return $sResponse;
    }
}