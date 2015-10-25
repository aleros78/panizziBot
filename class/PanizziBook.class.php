<?php
class PanizziBook {
    const AUTHOR_TD_POSITION = 1;
    const NAME_TD_POSITION = 2;
    const ID_TD_POSITION = 0;
    const DEADLINE_TD_POSITION = 3;
    const RENEWALS_TD_POSITION = 4;

    public $author = '';
    public $name = '';
    public $id = '';
    public $deadline;
    public $renewals = 0;
    public $DOMNode;

    public function loadFromDOMNode ($hFieldList) {
        $this->DOMNode = $hFieldList;
        $this->author = $hFieldList->item(self::AUTHOR_TD_POSITION)->nodeValue;
        $this->name = $hFieldList->item(self::NAME_TD_POSITION)->nodeValue;
        $this->id = $hFieldList->item(self::ID_TD_POSITION)->nodeValue;
        $this->deadline = new DateTime($hFieldList->item(self::DEADLINE_TD_POSITION)->nodeValue);
        $this->renewals = intval($hFieldList->item(self::RENEWALS_TD_POSITION)->nodeValue);
    }
}