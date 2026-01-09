<?php

namespace App\Http\Controllers;

use App\Models\BusinessPartner;
use App\Models\BusinessPartnerRole;
use App\Models\Address;
use App\Models\BusinessPartnerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusinessPartnerController extends Controller

{
    // LISTAR
    public function index()
    {
        $businessPartners = BusinessPartner::with('roles')->get();
        return view('app.business_partner.index', compact('businessPartners'));
    }

    // FORMULÁRIO CREATE
    public function create()
    {
        return view('app.business_partner.create');
    }
    public function store(Request $request)
    {
        // 1️⃣ Validação
        $validated = $request->validate([
            'type' => 'required|in:PF,PJ',
            'document' => 'required|unique:business_partners,document',

            // PF
            'name_first' => 'required_if:type,PF',
            'name_last'  => 'required_if:type,PF',

            // PJ
            'company_name' => 'required_if:type,PJ',
        ]);

        // 2️⃣ Gera search_key (conceito ERP / SAP)
        $searchKey = $validated['type'] === 'PF'
            ? strtoupper($validated['name_first'] . ' ' . $validated['name_last'])
            : strtoupper($validated['company_name']);

        // 3️⃣ Cria o Business Partner
        BusinessPartner::create([
            'type' => $validated['type'],
            'document' => $validated['document'],
            'name_first' => $validated['name_first'] ?? null,
            'name_last' => $validated['name_last'] ?? null,
            'company_name' => $validated['company_name'] ?? null,
            'trade_name' => $validated['trade_name'] ?? null,
            'search_key' => $searchKey,
            'status' => 'ATIVO',
        ]);

        return redirect()
            ->route('business-partners.index')
            ->with('success', 'Business Partner cadastrado com sucesso');
    }



    // VISUALIZAR
    public function show($id)
    {
        $businessPartner = BusinessPartner::with([
            'roles',
            'addresses.address'
        ])->findOrFail($id);

        return view('app.business_partner.show', compact('businessPartner'));
    }

    // FORMULÁRIO EDIT
    public function edit($id)
    {
        $businessPartner = BusinessPartner::with([
            'roles',
            'addresses.address'
        ])->findOrFail($id);

        return view('app.business_partner.edit', compact('businessPartner'));
    }

    // ATUALIZAR
    public function update(Request $request, $id)
    {
        $businessPartner = BusinessPartner::findOrFail($id);

        $request->validate([
            'type' => 'required|in:PF,PJ',
            'document' => 'required|unique:business_partners,document,' . $id,
        ]);

        $businessPartner->update($request->all());

        return redirect()
            ->route('business-partners.index')
            ->with('success', 'Business Partner updated successfully');
    }

    // EXCLUIR
    public function destroy($id)
    {
        BusinessPartner::findOrFail($id)->delete();

        return redirect()
            ->route('business-partners.index')
            ->with('success', 'Business Partner deleted successfully');
    }
}
