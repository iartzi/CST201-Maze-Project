<?php

/**
 * Class BuildBlocks
 *
 * Builds teh block data for each of the block types.
 */
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

        // Iterates through the rows of the block
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

    /**
     * Builds a wall or open block
     *
     * @param $type
     *  - wall
     *  - open
     *
     * @return array
     */
    public function buildSpaceBlock($type) {
        $returnBlock = [];       // Create array instance
        $blockItem = "";
        $col = 1;
        $row = 1;

        // TODO: Could do some error checking...
        if ($type == 'open')
            $blockItem = $this->openItem;
        elseif ($type == 'wall')
            $blockItem = $this->wallItem;

        // Iterates through the rows of the block
        for ($r = $row; $r <= 3; $r++) {
            // Now iterate through the columns...
            for ($c = $col; $c <= 3; $c++) {
                // Write to array
                $returnBlock[$r][$c] = $blockItem;
            }
        }

        return $returnBlock;
    }

}