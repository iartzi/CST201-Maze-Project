<?php

/**
 * Class SetupMaze
 *
 * Takes a Maze file and builds the data for the maze attributes.
 */
class SetupMaze {

    protected $mazeFile;                    // The maze filename passed to the constructor

    protected $dotPointer = 0;              // Defines dot (.) pointer of text file
    protected $mazeDimensions = [];         // Defines maze dimensions
    protected $mazeBlockArray = [];         // Defines the coordinates and block type of blocks

    function __construct($mazeFile) {
        $this->mazeFile = $mazeFile;

        $this->buildMazeData();
    }

    /**
     * Returns the maze dimensions (colums, rows)
     *
     * @return array
     */
    public function getMazeDimensions() {
        return $this->mazeDimensions;
    }

    /**
     * Returns the maze blocks and block types array
     *
     * @return array
     */
    public function getMazeBlocks() {
        return $this->mazeBlockArray;
    }

    private function buildMazeData() {
        $blockBuilder = new BuildBlocks();

        // Open the maze file
        $mazeFileHandle = fopen($this->mazeFile, "r") or die("Unable to open maze file!");

        // If file handler exists
        if ($mazeFileHandle) {
            // Read each line of the maze
            while (!feof($mazeFileHandle)) {
                $line = trim( fgets($mazeFileHandle, 4096) );

                // Check if dotPointer exists
                if (substr($line, -1) == ".") {
                    $this->dotPointer++;

                    // Check which dotPointer you are at to see what needs to be done
                    // Pointer 1:   maze dimensions
                    // Pointer 2:   start
                    // Pointer 3:   finish
                    switch ($this->dotPointer) {
                        case 1:
                            // Remove the dot
                            $line = str_replace(".", "", $line);

                            // Get array of numbers
                            $dim = explode(", ", $line);
                            $this->mazeDimensions['columns'] = $dim[0];
                            $this->mazeDimensions['rows']    = $dim[1];
                            break;
                        case 2:
                            // Remove the dot and parenthesis
                            $line = str_replace([".", "(", ")"], [""], $line);

                            // Get array of numbers
                            $start                                               = explode(", ", $line);
                            $this->mazeBlockArray[$start[0]][$start[1]]['id']    = 'start';
                            $this->mazeBlockArray[$start[0]][$start[1]]['block'] = $blockBuilder->buildIndicatorBlock('start');
                            break;
                        case 3:
                            // Remove the dot and parenthesis
                            $line = str_replace([".", "(", ")"], [""], $line);

                            // Get array of numbers
                            $finish                                                = explode(", ", $line);
                            $this->mazeBlockArray[$finish[0]][$finish[1]]['id']    = 'finish';
                            $this->mazeBlockArray[$finish[0]][$finish[1]]['block'] = $blockBuilder->buildIndicatorBlock('finish');
                            break;
                        case 4:
                            // Remove the dot
                            $line = str_replace(".", "", $line);

                            // Get array of numbers
                            $lastLine = explode("), (", $line);

                            foreach ($lastLine as &$val) {
                                // Remove the parenthesis
                                $val                                                               = str_replace([
                                  "(",
                                  ")"
                                ], [""], $val);
                                $lastLineVals                                                      = explode(", ", $val);
                                $this->mazeBlockArray[$lastLineVals[0]][$lastLineVals[1]]['id']    = 'wall';
                                $this->mazeBlockArray[$lastLineVals[0]][$lastLineVals[1]]['block'] =
                                  $blockBuilder->buildSpaceBlock('wall');
                            }
                            unset($val);

                            break;
                    }
                } else {
                    // Not a pointer line with a dot (.), so treat as regular wall blocks

                    // Remove the dot
                    $line = str_replace(".", "", $line);

                    // Get array of numbers
                    $thisLine = explode("), (", $line);

                    foreach ($thisLine as &$val) {
                        // Remove the parenthesis
                        $val          = str_replace(["(", ")", "."], [""], $val);
                        $thisLineVals = explode(", ", $val);

                        // Remove the dot or parentheses from ending variable
                        $thisLineVals[1] = str_replace([".", ","], "", $thisLineVals[1]);

                        $this->mazeBlockArray[$thisLineVals[0]][$thisLineVals[1]]['id']    = 'wall';
                        $this->mazeBlockArray[$thisLineVals[0]][$thisLineVals[1]]['block'] = $blockBuilder->buildSpaceBlock
                        ('wall');
                    }
                    unset($val);
                }
            }

            fclose($mazeFileHandle);
        }

        // Go through the array and check if a block exists. If not, set it as a space
        for ($c = 0; $c < $this->getMazeDimensions()['columns']; $c++) {
            for ($r = 0; $r < $this->getMazeDimensions()['rows']; $r++) {
                // If this row/column is empty, we are assuming this is an open space
                if (empty($this->mazeBlockArray[$c][$r])) {
                    $this->mazeBlockArray[$c][$r]['id'] = 'open';
                    $this->mazeBlockArray[$c][$r]['block'] = $blockBuilder->buildSpaceBlock('open');
                }
            }
        }
    }
}