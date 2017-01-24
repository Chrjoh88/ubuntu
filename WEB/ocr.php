<?php
/**
 * OCR Number generation function
 *
 * @param string $base_number
 *   The base number that you wish to use for the OCR nr. Can be any number,
 *   but usually consists of client ID combined with invoice ID or similar.
 * @param boolean $length
 *   Use length if you want the OCR number to add a length
 *   number as the second to last digit, before the control digit.
 *   The length digit represents the length of the whole OCR, including the
 *   control digit. If the length is > 9 the second digit is used.
 * @return string
 *   the complete and ready OCR number.
 *
 */
function ocr_generate($base_number, $length = TRUE) {
  // Add the length number
  if ($length) {
    $base_number = $base_number . substr(strlen($base_number) + 2, -1);
  }
  // Convert the number into an array
  $base_number = str_split($base_number);
  // Reverse the array for easier handling
  $reversed = array_reverse($base_number);
  // Double every other digit
  $doubled = double_every_other($reversed);
  // Calculate the sum of all the digits
  $sum = sum_of_digits($doubled);
  // Get the diff between the sum and the nearest two digit whole number
  $control_digit = abs((ceil($sum / 10) * 10) - $sum);
  $ocr = implode($base_number);
  return $ocr . $control_digit;
}
/**
 * Helper function that doubles every other digit in the array
 */
function double_every_other($reversed) {
  // Loop through the reversed base number array and multiply each number by
  // its proper weight.
  foreach ($reversed as $key => $value) {
    if ($key % 2 == 0) {
      $reversed[$key] = $value * 2;
    }
  }
  return $reversed;
}
/**
 * Helper function that calculates the sum of all digits.
 * See the Wikipedia article on Luhn's algorithm for more info.
 */
function sum_of_digits($doubled) {
  $sum = 0;
  // Loop through the doubled base number array and recalculates its value based
  // on the sum of digits.
  foreach ($doubled as $key => $value) {
    $plus = $value > 9 ? 1 : 0;
    $doubled[$key] = $value % 10 + $plus;
    $sum = $sum + $doubled[$key];
  }
  return $sum;
}
print ocr_generate('313656689');
?>
