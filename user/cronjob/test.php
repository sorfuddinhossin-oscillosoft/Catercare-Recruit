<?php

// The text string

$text = '• A personal belief in a safety first culture • Exceptional customer service skills • Enthusiastic, motivated and reliable • Be a team player with a "can do" attitude • A current manual driver\'s licence is required • Previous experience in a similar role would be a distinct advantage Details of two current referees must be provided at the interview.';

echo 'Original :'.$text.'<hr />';

// The word we want to replace

$oldWord = "•";



// The new word we want in place of the old one

$newWord = "<br />•";



// Run through the text and replaces all occurrences of $oldText

$text = str_replace($oldWord , $newWord , $text);



// Display the new text

echo $text;



?>

