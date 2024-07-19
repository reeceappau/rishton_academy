<?php
function has_valid_email_format($value) {
    $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    return preg_match($email_regex, $value) === 1;
}

function is_valid_postcode($postcode) {
    // Define the regex pattern for UK postcodes
    $pattern = '/^([A-Z]{1,2}[0-9][0-9]?[A-Z]?)\s*([0-9][A-Z]{2})$/i';

    // Check if the postcode matches the pattern
    if (preg_match($pattern, trim($postcode))) {
        return true; // Valid postcode
    }
    return false; // Invalid postcode
}

function is_valid_phone($phoneNumber) {
    // Define the regex pattern for UK phone numbers
    $pattern = '/^(\+44|0)7\d{9}$|^(\+44|0)\d{4}\s?\d{6}$|^(\+44|0)\d{3}\s?\d{3}\s?\d{4}$/';

    // Check if the phone number matches the pattern
    return preg_match($pattern, trim($phoneNumber)) === 1;
}

function is_blank($value) {
    return !isset($value) || trim($value) === '';
}

function has_length_greater_than($value, $min) {
    $length = strlen($value);
    return $length > $min;
}


function has_length_less_than($value, $max) {
    $length = strlen($value);
    return $length < $max;
}


function has_length_exactly($value, $exact) {
    $length = strlen($value);
    return $length == $exact;
}

function has_length($value, $options) {
    if(isset($options['min']) && !has_length_greater_than($value, $options['min'] - 1)) {
        return false;
    } elseif(isset($options['max']) && !has_length_less_than($value, $options['max'] + 1)) {
        return false;
    } elseif(isset($options['exact']) && !has_length_exactly($value, $options['exact'])) {
        return false;
    } else {
        return true;
    }
}

?>