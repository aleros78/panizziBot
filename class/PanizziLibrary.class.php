<?php
class PanizziLibrary {
    public $name = '';
    public $DOMNode;

    public function __construct ($hNode) {
        if ($hNode instanceof DOMNode) {
            $this->loadFromDOMNode($hNode);
        }
    }

    public function loadFromDOMNode ($hNode) {
        $this->DOMNode = $hNode;
        $this->name = $hNode->nodeValue;
    }
}