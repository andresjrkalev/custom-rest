<?php

class TokenUtil {

  public static function create($user) {
    $headers = [];
    $headers[KEY_ALGORITHM] = VALUE_ALGORITHM;
    $headers[KEY_TYPE] = VALUE_TYPE;
    $headersEncoded = base64urlEncode(json_encode($headers));

    $payload = [];
    $payload[PROPERTY_USERNAME] = $user->getUsername();
    $payloadEncoded = base64urlEncode(json_encode($payload));

    $key = 'secret';
    $signaturePart = FormatUtil::formatString(PATTERN_SIGNATURE, $headersEncoded, $payloadEncoded);
    $signature = hash_hmac(HASH_FUNCTION, $signaturePart, $key, true);
    $signatureEncoded = base64urlEncode($signature);

    return FormatUtil::formatString(PATTERN_TOKEN, $headersEncoded, $payloadEncoded, $signatureEncoded);
  }
  
  private function base64urlEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), SYMBOL_EQUALS);
  }
  
  public static function validate($token) {
    
  }
}
