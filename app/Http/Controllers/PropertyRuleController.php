<?php

namespace App\Http\Controllers;

use App\DataTables\PropertyRuleDataTable;
use App\Http\Requests\StorePropertyRuleRequest;
use App\Http\Requests\UpdatePropertyRuleRequest;
use App\Models\PropertyRule;

class PropertyRuleController extends Controller
{
    /**
     * Display a listing of the global property rules.
     */
    public function index(PropertyRuleDataTable $dataTable)
    {
        return $dataTable->render('property_rule.index');
    }

    /**
     * Show the form for creating a new rule.
     */
    public function create()
    {
        $this->data['action'] = route('property_rules.store');
        $this->data['rule_data'] = null;
        return view('property_rule.form', $this->data);
    }

    /**
     * Store a newly created rule in storage.
     */
    public function store(StorePropertyRuleRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $rule = PropertyRule::create($data);

        // Auto-translate with Gemini AI and Save Translations
        $rule->autoTranslateAndSave([
            'title'       => $data['title'] ?? '',
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('property_rules.index')->with('success', 'Peraturan Villa berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified rule.
     */
    public function edit(PropertyRule $property_rule)
    {
        $this->data['rule_data'] = $property_rule;
        $this->data['action'] = route('property_rules.update', $property_rule->uuid);
        return view('property_rule.form', $this->data);
    }

    /**
     * Update the specified rule in storage.
     */
    public function update(UpdatePropertyRuleRequest $request, PropertyRule $property_rule)
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $property_rule->update($data);

        // Auto-translate with Gemini AI and Save Translations
        $property_rule->autoTranslateAndSave([
            'title'       => $data['title'] ?? $property_rule->title,
            'description' => $data['description'] ?? $property_rule->description,
        ]);

        return redirect()->route('property_rules.index')->with('success', 'Peraturan Villa berhasil diperbarui!');
    }

    /**
     * Remove the specified rule from storage.
     */
    public function destroy(PropertyRule $property_rule)
    {
        $property_rule->delete();

        return redirect()->route('property_rules.index')->with('success', 'Peraturan Villa berhasil dihapus!');
    }
}
