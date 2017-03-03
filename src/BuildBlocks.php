<?php

namespace src;

class BuildBlocks {

    protected $openItem = ".";
    protected $wallItem = "X";
    protected $startLetter = "S";
    protected $finishLetter = "F";

    /**
     * Creates the start or finishing block for the maze
     *
     * @param $type
     *  - start
     *  - finish
     *
     * @return array
     */
    public function buildIndicatorBlock($type) {
        $returnBlock = [];       // Create array instance
        $letterToUse = "";
        $col = 1;
        $row = 1;
        
        // TODO: Could do some error checking...
        if ($type == 'start')
            $letterToUse = $this->startLetter;
        elseif ($type == 'finish')
            $letterToUse = $this->finishLetter;

        // Iterates through the rows
        for ($r = $row; $r <= 3; $r++) {
            // Now iterate through the columns...
            for ($c = $col; $c <= 3; $c++) {
                // Write to array based on row/col
                if ($r == 2 && $c == 2) {
                    $returnBlock[$r][$c] = $letterToUse;
                } else {
                    $returnBlock[$r][$c] = $this->openItem;
                }
            }
        }

        return $returnBlock;
    }

}

$blockBuilder = new BuildBlocks();
var_dump( $blockBuilder->buildIndicatorBlock('start') );
var_dump( $blockBuilder->buildIndicatorBlock('finish') );