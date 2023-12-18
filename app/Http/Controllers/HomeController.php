<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Car;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::latest();

        // Search logic
        $search = $request->input('search');
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Filtering logic (Assuming 'category' is a column in the Car model)
        $category = $request->input('category');
        if ($category) {
            $query->where('category', $category);
        }

        $cars = $query->paginate(10);

        return view("frontend.homepage", compact('cars'));
    }

    public function contact()
    {
        return view("frontend.contact");
    }

    public function contactStore(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'pesan' => 'required',
        ]);
        Message::create($data);

        return redirect()->back()->with([
            'message' => 'pesan anda berhasil dikirim',
            'alert-type' => 'success'
        ]);
    }

    public function detail(Car $car)
    {
        return view("frontend.detail", compact('car'));
    }
}
