<?php
function __autoload($className) {
    include "src/" . $className . '.php';
}

$mazeInfo = new SetupMaze(__DIR__ . "/assets/mazePoints.txt");

// WRITE MAZE TO FILE
// Create file
$mazeDiagram = fopen("assets/mazeDiagram.txt", "w") or die("Unable to open file!");

// Go through each row of the output file.
// Set number of rows associated with how many lines the maze will
// have based upon the number of rows.
$linesForFile = 1 + ($mazeInfo->getMazeDimensions()['rows'] * 3);
$currentWritingRow = 0;
$internalBlockRow = 1;      // While in a block, save which row in the block you are at

for ($currentLine = 1; $currentLine <= $linesForFile; $currentLine++) {
    // First line, so write the column numbers
    if ($currentLine == 1) {
        fwrite($mazeDiagram, " ");      // Write first space

        for ($v = 0; $v < $mazeInfo->getMazeDimensions()['columns']; $v++) {
            fwrite($mazeDiagram, "  " . $v);    // Write the column numbers
        }

        fwrite($mazeDiagram, "  \n");       // Write ending
    } else {
        // Write all other lines
        if ($currentLine % 3 == 0) {
            // See how many numbers are in the row and add space accordingly.
            // We are ASSUMING we will never have more than 99 rows.
            if (strlen($currentWritingRow) == 1) {
                fwrite($mazeDiagram, $currentWritingRow." ");
            } else {
                fwrite($mazeDiagram, $currentWritingRow);
            }
        } else {
            fwrite($mazeDiagram, "  ");     // Write blank spaces
        }

        // Write the block spaces

        // TODO: Only modulus 3 will point out second row.  Need to add one for 1 and 3 as well
        if ($currentLine % 3 == 0) {
            $internalBlockRow = 2;
        } else {
            $internalBlockRow = 1;
        }

        // Go through each column
        for($col = 0; $col < $mazeInfo->getMazeDimensions()['columns']; $col++) {
            foreach ($mazeInfo->getMazeBlocks()[$col][$currentWritingRow]['block'][$internalBlockRow] as $blockItem) {
                fwrite($mazeDiagram, $blockItem);
            }
        }

        // Increment current writing row based on the line we are at
        if (($currentLine - 1) % 3 == 0) {
            $currentWritingRow++;
        }

        fwrite($mazeDiagram, "\n");     // Write ending
    }
}