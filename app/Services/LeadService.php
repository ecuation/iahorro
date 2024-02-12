<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Lead;

class LeadService
{
    private $leadScoringService;
    function __construct()
    {
        $this->leadScoringService = new LeadScoringService();
    }

    public function createLeadFromClient(Client $client, array $leadData): Lead
    {
        $leadData['client_id'] = $client->id;
        $leadData['score'] = $this->leadScoringService->getLeadScore($leadData);
        $lead = Lead::create($leadData);

        return $lead;
    }

    public function updateLead(Lead $lead, $leadData): Lead
    {
        $lead->score = $this->leadScoringService->getLeadScore($lead->attributesToArray());
        $lead->update($leadData);

        return $lead;
    }
}
