<?php

namespace App\Services;


class LeadScoringService
{
    public function getLeadScore(array $leadData): int
    {
        return rand(0, 100);
    }
}
