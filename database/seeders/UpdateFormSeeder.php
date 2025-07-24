<?php

namespace Database\Seeders;

use App\Models\CurrentAlternative;
use App\Models\Form;
use App\Models\UserRanking;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UpdateFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $form = Form::query()->create([
            'user_id' => 1,
            'code' => Str::uuid(),
            'title' => "Title Formulir",
            'expired_date' => Carbon::now()->format('Y-m-d'),
        ]);

        UserRanking::query()->whereNull('form_id')
            ->update([
                'form_id' => $form->id,
            ]);

        $currentAlternatives = CurrentAlternative::query()
            ->where('score_akhir', 0)->get();

        foreach ($currentAlternatives as $currentAlternative) {
            $scoreAkhir = $currentAlternative->score * 100;
            $currentAlternative->update(['score_akhir' => $scoreAkhir]);
        }
    }
}
