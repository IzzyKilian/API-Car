<?php

namespace App\Http\Controllers\Admin;

use App\Models\Car;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CarStoreRequest;
use App\Http\Requests\Admin\CarUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 


class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function apiIndex(Request $request): JsonResponse
    {
        $query = Car::query();

        

        $cars = $query->paginate(5);

        
        return response()->json(['cars' => $cars], 200);
    }
    public function index(Request $request)
    {
        $query = Car::query();

        // Check if the request has a search parameter
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('nama_mobil', 'like', '%' . $searchTerm . '%')
                ->orWhere('status', 'like', '%' . $searchTerm . '%');
        }
        
        
        // Check if the request has a status parameter
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        $cars = $query->paginate(5);

        return view('admin.cars.index', compact('cars'));
    }
    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('admin.cars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarStoreRequest $request)
{
    $request->validate([
        'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:1028|', 
        
    ]);

    try {
        $gambar = $request->file('gambar')->store('assets/car', 'public');
        $slug = Str::slug($request->nama_mobil, '-');

        Car::create($request->except('gambar') + ['gambar' => $gambar, 'slug' => $slug]);

        return redirect()->route('admin.cars.index')->with([
            'message' => 'Data successfully created',
            'alert-type' => 'success',
        ]);
    } catch (\Exception $e) {
        return redirect()->route('admin.cars.index')->with([
            'message' => 'Error creating data: ' . $e->getMessage(),
            'alert-type' => 'error',
        ]);
    }
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        return view('admin.cars.edit',compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $carId)
{
    $request->validate([
        'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:1028|', 
        // Add the dimensions rule to restrict image dimensions if needed
    ]);

    $carImage = Car::findOrFail($carId);

    try {
        if ($request->hasFile('gambar')) {
            if ($carImage->gambar && Storage::disk('public')->exists($carImage->gambar)) {
                unlink(storage_path('app/public/' . $carImage->gambar));
            }

            $gambar = $request->file('gambar')->store('assets/car', 'public');
            $carImage->update(['gambar' => $gambar]);
        }

        return redirect()->back()->with([
            'message' => 'Gambar berhasil diedit',
            'alert-type' => 'info',
        ]);
    } catch (\Exception $e) {
        return redirect()->back()->with([
            'message' => 'Error editing image: ' . $e->getMessage(),
            'alert-type' => 'error',
        ]);
    }
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
{
    if ($car->gambar && Storage::disk('public')->exists($car->gambar)) {
        unlink(storage_path('app/public/'.$car->gambar));
    }

    $car->delete();

    return redirect()->back()->with([
        'message' => 'Data berhasil dihapus',
        'alert-type' => 'danger'
    ]);
}

    public function updateImage(Request $request, $carId)
{
    $request->validate([
        'gambar' => 'required|image'
    ]);
    $carImage = Car::findOrfail($carId);
    if($request->gambar){
        unlink('storage/'. $carImage->gambar );
        $gambar = $request->file('gambar')->store('assets/car', 'public');

        $carImage->update(['gambar' => $gambar]);
    }
    return redirect()->back()->with([
        'message' => 'gambar berhasil diedit',
        'alert-type' => 'info'
    ]);
}
}