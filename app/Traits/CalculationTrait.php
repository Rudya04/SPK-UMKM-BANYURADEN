<?php

namespace App\Traits;

trait CalculationTrait
{
    public function normalizationBobot(array $criterias): array
    {
        $total = array_sum(array_column($criterias, 'value'));
        foreach ($criterias as &$k) {
            $k['bobot_normal'] = round($k['value'] / $total, 2);
        }
        return $criterias;
    }

    public function calculationScore($normalizations, $rankings, $maxs)
    {
        $result = [];
        $collect = collect($rankings);
        $maximal = collect($maxs);
        foreach ($normalizations as $normalization) {
            $score = 0;
            $ranking = $collect->where('criteria_id', $normalization['id'])->first();
            $max = $maximal->where('criteria_id', $normalization['id'])->first();
            $normal = round($ranking->sub_criteria->value / $max->value_max, 2);
            $score = $normal * $normalization['bobot_normal'];
            $result[] = [
                'criteria_id' => $ranking->criteria_id,
                'criteria_name' => $ranking->criteria->name,
                'criteria_value' => $ranking->criteria->value,
                'sub_criteria_id' => $ranking->sub_criteria_id,
                'sub_criteria_name' => $ranking->sub_criteria->name,
                'sub_criteria_value' => $ranking->sub_criteria->value,
                'bobot_normal' => $normalization['bobot_normal'],
                'value_normal' => $normal,
                'score' => round($score, 2),
            ];
        }

        return $result;
    }

    public function findStatusScore($score)
    {
        if ($score >= 0.8) {
            return 'Sangat Layak';
        } elseif ($score >= 0.7) {
            return 'Layak';
        } elseif ($score >= 0.6) {
            return 'Cukup Layak';
        } else {
            return 'Tidak Layak';
        }
    }
}
