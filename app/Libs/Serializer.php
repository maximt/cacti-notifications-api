<?php

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

$encoders = [new JsonEncoder()];
$normalizers = [new ObjectNormalizer()];

return new Serializer($normalizers, $encoders);
