<?php

namespace App\Http\Controllers;

use App\DataTables\PaymentMethodDataTable;
use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;
use App\Models\PaymentMethod;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PaymentMethodDataTable $dataTable)
    {
        return $dataTable->render('payment_method.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['action'] = route('payment_methods.store');
        return view('payment_method.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentMethodRequest $request, ImageService $imageService)
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active') ? true : false;

        if ($request->hasFile('logo_provider')) {
            $file = $request->file('logo_provider');
            $compressed = $imageService->compress($file);
            $filename = 'payment-methods/logo/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $compressed);
            $data['logo_provider'] = $filename;
        }

        if ($request->hasFile('image_qris')) {
            $file = $request->file('image_qris');
            $compressed = $imageService->compress($file);
            $filename = 'payment-methods/qris/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $compressed);
            $data['image_qris'] = $filename;
        }

        PaymentMethod::create($data);

        return redirect()->route('payment_methods.index')->with('success', 'Payment Method created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $payment_method)
    {
        $this->data['payment_method_data'] = $payment_method;
        $this->data['action'] = route('payment_methods.update', $payment_method->uuid);
        return view('payment_method.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $payment_method, ImageService $imageService)
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active') ? true : false;

        if ($request->hasFile('logo_provider')) {
            if ($payment_method->logo_provider && Storage::disk('public')->exists($payment_method->logo_provider)) {
                Storage::disk('public')->delete($payment_method->logo_provider);
            }

            $file = $request->file('logo_provider');
            $compressed = $imageService->compress($file);
            $filename = 'payment-methods/logo/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $compressed);
            $data['logo_provider'] = $filename;
        }

        if ($request->hasFile('image_qris')) {
            if ($payment_method->image_qris && Storage::disk('public')->exists($payment_method->image_qris)) {
                Storage::disk('public')->delete($payment_method->image_qris);
            }

            $file = $request->file('image_qris');
            $compressed = $imageService->compress($file);
            $filename = 'payment-methods/qris/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $compressed);
            $data['image_qris'] = $filename;
        }

        $payment_method->update($data);

        return redirect()->route('payment_methods.index')->with('success', 'Payment Method updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $payment_method)
    {
        if ($payment_method->logo_provider && Storage::disk('public')->exists($payment_method->logo_provider)) {
            Storage::disk('public')->delete($payment_method->logo_provider);
        }

        if ($payment_method->image_qris && Storage::disk('public')->exists($payment_method->image_qris)) {
            Storage::disk('public')->delete($payment_method->image_qris);
        }

        $payment_method->delete();

        return redirect()->route('payment_methods.index')->with('success', 'Payment Method deleted successfully!');
    }
}
