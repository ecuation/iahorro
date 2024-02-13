<?php
namespace App\Http\Controllers;

use App\Helpers\HTTPResponseHelper;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use App\Services\ClientService;
use App\Services\LeadService;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LeadController extends Controller
{
    private $clientService;

    private $leadService;

    public function __construct()
    {
        $this->clientService = new ClientService();
        $this->leadService = new LeadService();
    }

    public function store(StoreLeadRequest $request)
    {
        DB::beginTransaction();
        try {
            $clientData = $request->only(['name', 'email', 'phone']);
            $leadData = $request->except(['name', 'phone', 'email']);
            $client = $this->clientService->storeOrUpdateClientIfExists($clientData);
            $lead = $this->leadService->createLeadFromClient($client, $leadData);
            DB::commit();
        }catch (\Exception $exception) {
            DB::rollback();
            throw new HttpException(500, $exception->getMessage());
        }

        return new LeadResource($lead);
    }

    public function show($id)
    {
        $lead = Lead::find($id);
        if (!$lead) {
            return HTTPResponseHelper::notFoundResponse();
        }
        return new LeadResource($lead);
    }

    public function update(UpdateLeadRequest $request, $id)
    {
        $data = $request->only(['mortgage_request_amount', 'purpose_mortgage']);
        $lead = Lead::find($id);

        if (!$lead) {
            return HTTPResponseHelper::notFoundResponse();
        }

        $this->leadService->updateLead($lead, $data);

        return new LeadResource($lead);
    }

    public function destroy($id)
    {
        $lead = Lead::find($id);
        if (!$lead) {
            return HTTPResponseHelper::notFoundResponse();
        }
        $lead->delete();

        return response()->json([
            'message' => 'Lead deleted successfully'
        ]);
    }
}
