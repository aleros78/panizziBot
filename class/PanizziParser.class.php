<?php
class PanizziParser extends DOMXPath {
    const CARD_NUM_XPATH = '/html/body/div/b[1]/font';
    const LIBRARIES_XPATH = '/html/body/table/tbody/tr[1]/td/b/font';
    const LIBRARY_BOOKS_XPATH = './/tr[td[not(b)]]';
    const BOOK_DATA_XPATH = 'td';

    public function queryCardNumber () {
        return $this->query(self::CARD_NUM_XPATH);
    }

    public function queryLibrariesName () {
        return $this->query(self::LIBRARIES_XPATH);
    }

    public function queryLibraryBooks ($hLibrary) {
        $sTableXPath = $hLibrary->DOMNode->getNodePath() . '/ancestor::table';
        $hTableNode = $this->query($sTableXPath)->item(0);
        return $this->query(self::LIBRARY_BOOKS_XPATH, $hTableNode);
    }

    public function queryBookData ($hBookRow) {
        return $this->query(self::BOOK_DATA_XPATH, $hBookRow);
    }
}