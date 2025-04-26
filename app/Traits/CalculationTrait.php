<?php

namespace App\Traits;

trait CalculationTrait
{
    public function normalizationBobot(array $criterias): array
    {
        $total = array_sum(array_column($criterias, 'value'));
        foreach ($criterias as &$k) {
            $k['bobot_normal'] = round(($k['value'] / $total) * 100, 2) / 100;
        }
        return $criterias;
    }

    public function calculationScore($normalizations, $rankings, $maxs)
    {
        $result = [];
        $collect = collect($rankings);
        foreach ($normalizations as $normalization) {
            $score = 0;
            $ranking = $collect->where('criteria_id', $normalization['id'])->first();
            $max = $this->findMaxBySlug($maxs, $ranking->criteria->slug);
//            dd($ranking->sub_criteria->value, $max, $ranking->criteria->slug);
            $normal = $ranking->sub_criteria->value / $max;
            $score = $normal * $normalization['bobot_normal'];
            $result[] = [
                'criteria_id' => $ranking->criteria_id,
                'criteria_name' => $ranking->criteria->name,
                'criteria_value' => $ranking->criteria->value,
                'sub_criteria_id' => $ranking->sub_criteria_id,
                'sub_criteria_name' => $ranking->sub_criteria->name,
                'sub_criteria_value' => $ranking->sub_criteria->value,
                'score' => round($score, 2),
            ];
        }

        return $result;
    }

    private function findMaxBySlug($array, $slug)
    {
        foreach ($array as $item) {
            if ($item->name == $slug) {
                return $item->max_bobot;
            }
        }


        return 0;
    }
}
