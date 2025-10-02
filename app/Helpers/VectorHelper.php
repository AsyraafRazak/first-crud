<?php

namespace App\Helpers;

class VectorHelper
{
    public static function cosineSimilarity(array $a, array $b): float
    {
        $dot = 0.0;
        $normA = 0.0;
        $normB = 0.0;
        $len = min(count($a), count($b));
        for ($i = 0; $i < $len; $i++) {
            $dot += $a[$i] * $b[$i];
            $normA += $a[$i] ** 2;
            $normB += $b[$i] ** 2;
        }
        if ($normA == 0 || $normB == 0)
            return 0.0;
        return $dot / (sqrt($normA) * sqrt($normB));
    }
}