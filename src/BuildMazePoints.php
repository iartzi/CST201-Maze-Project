<?php

/**
 * Builds the maze points from the maze dimension file
 *
 * Class BuildMazePoints
 */
class BuildMazePoints {

    protected $pointsList;      // SplDoubleyLinkedList
    protected $mazeFile;        // Filename for the maze points

    public function __construct($mazeFile) {
        $this->mazeFile = $mazeFile;
        $this->pointsList = new SplDoublyLinkedList();

        $this->readFile();
    }

    /**
     * Returns the double linked list of points from file
     *
     * @return mixed
     */
    public function getPointsList() {
        return $this->pointsList;
    }

    /**
     * Reads the file and adds the lines to the list
     */
    private function readFile() {
        $mazeFileHandle = fopen($this->mazeFile, "r") or die("Unable to open maze file!");

        // If file handler exists
        if ($mazeFileHandle) {
            // Read each line of the maze
            while (!feof($mazeFileHandle)) {
                $line = trim(fgets($mazeFileHandle, 4096));
                // Add to the end of linked list
                $this->pointsList->push($line);
            }
        }

        fclose($mazeFileHandle);
    }

}