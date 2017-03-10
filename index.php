<?php
/**
 * Maze Project
 * March, 2017
 * Ronald Pearl
 *
 * This application creates a maze based upon data points stored in a file.
 */


/**
 * Autoload class files
 *
 * @param $className
 */
function __autoload($className) {
    include "src/" . $className . '.php';
}

// Use SetupMaze class to read the file and create
// arrays for use in the rest of the program.
$mazeInfo = new SetupMaze(__DIR__ . "/assets/mazePoints.txt");

// Use WriteMaze to use the maze information and
// create a text file showing the maze.
$writeMaze = new WriteMaze($mazeInfo->getMazeDimensions(), $mazeInfo->getMazeBlocks(), __DIR__ . "/assets/mazeDiagram.txt");

echo "Maze Diagram Complete!";