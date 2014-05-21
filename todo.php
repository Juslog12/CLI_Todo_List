<?php

// Create array to hold list of todo items
$items = array();

// List array items formatted for CLI
function list_items($list)
{
	$result = '';
	foreach ($list as $key => $value) {
        // Display each item and a newline
       $add = $key + 1; 
       $result .= "[{$add}] {$value}\n";
    }
	
	return $result;
}
    // Return string of list items separated by newlines.
    // Should be listed [KEY] Value like this:
    // [1] TODO item 1
    // [2] TODO item 2 - blah
    // DO NOT USE ECHO, USE RETURN


		// $result = '';
    //loop through the list using foreach or for
    // foreach ($list as $key => $value) }
    	//echo Key +1 . 
		// }
		// return $result; 


// Get STDIN, strip whitespace and newlines, 
// and convert to uppercase if $upper is true
function get_input($upper = FALSE) 
{
	$result = trim(fgets(STDIN));
	return $upper? strtoupper($result) : $result;	
}

function sort_menu($items)
{
	echo '(A)-Z, (Z)-A, (O)rder Entered, (R)everse order entered : ';
	$input = get_input(true);
	 
	//if($input == 'A') {
	 	//asort($items);
	//} elseif($input == 'Z') {
	 	//arsort($items);
	//} elseif($input == 'O') {
	 	//ksort($items);
	//} elseif($input == 'R') {	
		//krsort($items); 
	//}	

	//$input = get_input(true);

	switch ($input) {
		case 'A':
			asort($items);
			break;
		case 'Z': 
			arsort($items);
		case 'O': 
			ksort($items);
		case 'R': 
			krsort($items);

	}	

	return $items;
}


function new_item_placement($items)
{
	echo '(B) to add item at the beginning, (E) to add item at the end, : ';
	$input = get_input(true);
	echo 'Enter item: ';
	$todo_item = get_input();

	if($input == 'B') {
		array_unshift($items, $todo_item);
	} elseif($input == 'E') {
		array_push($items, $todo_item);
	} else {
		array_push($items, $todo_item);
	}
	return $items;
}

function readtheFile($filename, $bytes = 100) {
	
	//var_dump($filename);

	if (empty($filename)) {
		$filename = './data/list.txt';
		//var_dump($filename);

	}
	
	$contents = ''; 
	if (is_readable($filename)) {
		$handle = fopen($filename, 'r');

		$contents = trim(fread($handle, $bytes));
		$array = explode(PHP_EOL, $contents);

		fclose($handle);
	}
	//var_dump($array);
	return $array;
}

function savefile($filename, $items) {
		if(file_exists($filename)) {
			echo "File already exist. Would you like to overwrite it? (Y or N)\n";
			$input = get_input(TRUE);
			if($input == 'Y'){
				$handle = fopen($filename, 'w');
				$list_items =implode($items);
				fwrite($handle, $list_items);
				fclose($handle);
				echo "$filename was saved succesfully.\n";
			} elseif($input = 'N') {
				//echo "Please select a new file name.\n";
			}	
		}
	}
// The loop!
do {
    // Iterate through list items
	echo list_items($items);

    // Show the menu options
    echo '(N)ew item, (R)emove item, (S)ort items, (O)pen file, s(A)ve, (Q)uit : ';

    // Get the input from user
    // Use trim() to remove whitespace and newlines
    $input = get_input(TRUE);

    // Check for actionable input
    if ($input == 'N') {
        // Ask for entry
        // Add entry to list array
        $items = new_item_placement($items);
    } elseif ($input == 'R') {
        // Remove which item?
        echo 'Enter item number to remove: ';
        // Get array key
       $input = get_input();  
    } elseif ($input == 'O') {
        // Remove which item?
        echo 'Please enter a filename: ';
        $filename = get_input();
        $items = readtheFile($filename, $bytes = 100);
    }elseif ($input == 'A') {
    	//Save file code
    	echo 'Please enter a filename: ';
    	$filename = get_input();
    	savefile($filename,$items); 
    } elseif($input == 'F') {
		array_shift($items);
	} elseif($input == 'L') {
		array_pop($items);
	} elseif ($input == 'S') {
        // Remove which item?
        $items = sort_menu($items);
        // Get array key
       $input = get_input();
        // Remove from array
        unset($items[$input - 1]);
     } //else {
     	//($)	 
// Exit when input is (Q)uit
} while ($input !== 'Q');

// Say Goodbye!
echo "Goodbye!\n";
// Exit with 0 errors
exit(0);