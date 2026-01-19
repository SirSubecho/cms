<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function stats()
    {
        $latestCustomer = Customer::latest()->first();

        return response()->json([
            'total' => Customer::count(),
            'lastAdded' => $latestCustomer
                ? $latestCustomer->created_at->diffForHumans()
                : null
        ]);
    }

    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = $request->get('per_page', 10);
        return $query->paginate($perPage);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers',
            'phone' => 'nullable|string|max:20',
            'street' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
        ]);

        return Customer::create($validated);
    }

    public function show(Customer $customer)
    {
        return $customer;
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'first_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'street' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
        ]);

        $customer->update($validated);
        return $customer;
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(['message' => 'Customer deleted']);
    }
}
