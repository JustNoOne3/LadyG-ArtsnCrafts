<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ShippingDetails;

class ShippingDetailsController extends Controller
{
    public function save(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Not authenticated'], 401);
        }
        $data = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'street_address' => 'required|string|max:255',
            'barrangay' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'is_default_address' => 'nullable|boolean',
        ]);

        // If setting as default, unset previous default
        if (!empty($data['is_default_address'])) {
            ShippingDetails::where('shipping_user', $userId)->update(['shipping_isDefault' => '0']);
        }

        $addressString = $data['street_address'] . ', ' . $data['barrangay'] . ', ' . $data['city'] . ', ' . $data['province'] . ', ' . $data['region'] . ', ' . $data['postal_code'];

        $shipping = ShippingDetails::create([
            'shipping_user' => $userId,
            'shipping_recipient' => $data['recipient_name'],
            'shipping_street' => $data['street_address'],
            'shipping_barrangay' => $data['barrangay'],
            'shipping_city' => $data['city'],
            'shipping_province' => $data['province'],
            'shipping_region' => $data['region'],
            'shipping_zip' => $data['postal_code'],
            'shipping_contactNo' => $data['contact_number'],
            'shipping_address' => $addressString,
            'shipping_isDefault' => !empty($data['is_default_address']) ? '1' : '0',
        ]);

        // Ensure only one default address (in case of race conditions)
        if ($shipping->shipping_isDefault == '1') {
            ShippingDetails::where('shipping_user', $userId)
                ->where('id', '!=', $shipping->id)
                ->update(['shipping_isDefault' => '0']);
        }

        return response()->json(['success' => true, 'address' => $shipping]);
    }

    public function update(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Not authenticated'], 401);
        }
        $data = $request->validate([
            'id' => 'required|integer|exists:shipping_details,id',
            'recipient_name' => 'required|string|max:255',
            'street_address' => 'required|string|max:255',
            'barrangay' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'is_default_address' => 'nullable|boolean',
        ]);

        $address = ShippingDetails::where('id', $data['id'])->where('shipping_user', $userId)->first();
        if (!$address) {
            return response()->json(['success' => false, 'message' => 'Address not found'], 404);
        }

        // If setting as default, unset previous default
        if (!empty($data['is_default_address'])) {
            ShippingDetails::where('shipping_user', $userId)->update(['shipping_isDefault' => '0']);
        }

        $addressString = $data['street_address'] . ', ' . $data['barrangay'] . ', ' . $data['city'] . ', ' . $data['province'] . ', ' . $data['region'] . ', ' . $data['postal_code'];

        $address->update([
            'shipping_recipient' => $data['recipient_name'],
            'shipping_street' => $data['street_address'],
            'shipping_barrangay' => $data['barrangay'],
            'shipping_city' => $data['city'],
            'shipping_province' => $data['province'],
            'shipping_region' => $data['region'],
            'shipping_zip' => $data['postal_code'],
            'shipping_contactNo' => $data['contact_number'],
            'shipping_address' => $addressString,
            'shipping_isDefault' => !empty($data['is_default_address']) ? '1' : '0',
        ]);

        // Ensure only one default address (in case of race conditions)
        if ($address->shipping_isDefault == '1') {
            ShippingDetails::where('shipping_user', $userId)
                ->where('id', '!=', $address->id)
                ->update(['shipping_isDefault' => '0']);
        }

        return response()->json(['success' => true, 'address' => $address]);
    }

    public function list(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['addresses' => []]);
        }
        $addresses = ShippingDetails::where('shipping_user', $userId)
            ->orderByDesc('shipping_isDefault')
            ->orderByDesc('id')
            ->get();
        return response()->json(['addresses' => $addresses]);
    }
}
