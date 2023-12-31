<!DOCTYPE html>
<html>
<head>
<title>PHP Code in HTML</title>
</head>
<body>
<?php
function old_extract_arabic_text($text) {
  // Check if the text is enclosed in double quotes.
  if (strpos($text, '"') !== false) {
    // Extract the Arabic text between the double quotes.
    $arabic_text = substr($text, strpos($text, '"'), strpos($text, '"', strpos($text, '"') + 1) - strpos($text, '"'));
  } else {
    // Check if the text is enclosed in a p tag.
    if (strpos($text, '<p>') !== false) {
      // Extract the Arabic text between the p tags.
      $arabic_text = substr($text, strpos($text, '<p>') + 3, strpos($text, '</p>') - strpos($text, '<p>') - 3);
    } else {
      // Check if the text starts with any of the supported keywords.
      $keywords = array('Focus Keyphrase:', 'The focus keyphrase for the given sentence is', 'The keyphrase for the given text is:', 'Possible focus keyphrase:', 'The Focus Keyphrase for this sentence could be');
      foreach ($keywords as $keyword) {
        if (strpos($text, $keyword) !== false) {
          // Extract the Arabic text after the keyword.
          $arabic_text = substr($text, strpos($text, $keyword) + strlen($keyword));
          break;
        }
      }

      // If the text does not start with any of the supported keywords, then the text is not in a supported format.
      if ($arabic_text === '') {
        $arabic_text = '';
      }
    }
  }

  // Return the extracted Arabic text.
  return $arabic_text;
}

function extract_arabic_text($text) {

  // If the text is more than 191 characters long, then only extract the text between "".
  if (strlen($text) > 191) {

    // Find the position of the first occurrence of the left double quote.
    $start_position = strpos($text, '"');
    
    // Find the position of the next occurrence of the right double quote after the first occurrence.
    $end_position = strpos($text, '"', $start_position + 1);

    // If the second occurrence of the quote is not found, then the text between the two occurrences is the entire rest of the string.
    if ($end_position === false) {
      $end_position = strlen($text);
    }
  
    // Extract the text between the two occurrences.
    $text_between_quotes = substr($text, $start_position + 1, $end_position - $start_position - 1);
  
    // Return the extracted text.
    return $text_between_quotes;
        
  } else {
    // Check if the text starts with any of the supported keywords.
    $keywords = array('Focus Keyphrase:', 'The focus keyphrase for the given sentence is', 'The keyphrase for the given text is:', 'Possible focus keyphrase:', 'The Focus Keyphrase for this sentence could be', 'The focus keyphrase for your input is');
    foreach ($keywords as $keyword) {
      if (strpos($text, $keyword) !== false) {
        // Extract the Arabic text after the keyword and remove the double quotes.
        $arabic_text = substr($text, strpos($text, $keyword) + strlen($keyword));
        $arabic_text = preg_replace('/"+/', '', $arabic_text);
        break;
      } else {
        $arabic_text = substr($text, strpos($text, '"'), strpos($text, '"', strpos($text, '"') ) - strpos($text, '"'));
      }
    }

    // If the text does not start with any of the supported keywords, then the text is not in a supported format.
    if ($arabic_text === '') {
      // Extract the Arabic text between the double quotes.
      $arabic_text = preg_replace('/"+/', '', $text);
    }

    // Remove the single quotes.
    $arabic_text = preg_replace("/'/", "", $arabic_text);
  
    // Return the extracted Arabic text.
    return $arabic_text;
  }
}



// Get the text to be processed.
$text = '
<p>"متى يصل أنتوني موديست إلى الأهلي؟" does not seem to be a phrase that can be optimized for focus keyphrase. It appears to be a specific question about the arrival time of Anthony Modeste to Al-Ahli club. A focus keyphrase is usually a concise and descriptive phrase that summarizes the main topic or theme of a piece of content.</p>
';

$to_be =  '
T
<p>Focus Keyphrase: قراصنة يسرقون 200 مليون دولار من العملات المشفّرة</p>
<p>Focus Keyphrase: مدرب الزمالك يُطمئن الجماهير على فترة الإعداد</p>
<p>Focus Keyphrase: السيطرة على الذكاء الاصطناعي</p>
<p>Focus Keyphrase: عودة أوسوريو قائدًا لتدريبات الزمالك في القاهرة</p>
<p>تعاقد النادي الأهلي مع موديست</p>
<p>The Focus Keyphrase for this sentence could be "تدريب الزمالك يوم السبت المقبل على ملعب النادي".</p>
<p>Focus Keyphrase: "مجدي جماهير الزمالك"</p>
<p>The focus keyphrase for the given sentence is "ثغرة خطيرة في برنامج التجسس الإسرائيلي التي تؤثر على آيفون"</p>
<p>The keyphrase for the given text is: "عودة روسيا لنظام سويفت"</p>
<p>"معسكر النمسا"</p>
<p>"مؤشر أسعار الغذاء في أدنى مستوى له في عامين على الرغم من ارتفاع أسعار الأرز"</p>
<p>"ميركاتو بلس | هل يمكن أن يكون عامل السن سببًا في دفع الأهلي ثمنها مع موديست؟"</p>
<p>\'معسكر النمسا\'</p>

';
// Extract the Arabic text from the input text.
$arabic_text = extract_arabic_text($text);

// Print the extracted Arabic text.
echo $arabic_text;

?>
</body>
</html>
