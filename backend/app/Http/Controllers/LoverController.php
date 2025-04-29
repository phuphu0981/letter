<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lover;
use App\Models\Memory;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LoverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lovers = Lover::all(); // Lấy tất cả các Lover từ database
        return view('admin', compact('lovers')); // Truyền danh sách Lover đến view admin
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.lovers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Store method called with data:', $request->all()); // Log dữ liệu nhận được

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pass' => 'required|string|min:6',
            'content_letter' => 'nullable|string',
            'text_profile' => 'nullable|string',
            'text_letter' => 'nullable|string',
            'memory' => 'nullable|json',
        ]);

        try {
            if ($request->hasFile('avatar')) {
                // Save avatar to Cloudinary in the 'avatar' folder
                $validatedData['avatar'] = $this->saveToCloudinary($request->file('avatar'));
            }

            Lover::create($validatedData);

            return redirect()->route('lover.index')->with('success', 'Lover created successfully.');
        } catch (\Exception $e) {
            Log::error('Error storing lover:', ['error' => $e->getMessage()]); // Log lỗi nếu xảy ra
            return redirect()->back()->withErrors('An error occurred while saving the lover.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lover = Lover::findOrFail($id);
        return view('lovers.edit', compact('lover'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lover = Lover::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000',
            'pass' => 'sometimes|required|string|min:6',
            'content_letter' => 'nullable|string',
            'text_profile' => 'nullable|string',
            'text_letter' => 'nullable|string',
            'memory' => 'nullable|json',
        ]);

        if ($request->hasFile('avatar')) {
            // Save new avatar to Cloudinary in the 'avatar' folder
            $validatedData['avatar'] = $this->saveToCloudinary($request->file('avatar'));
        }

        $lover->update($validatedData);

        return redirect()->route('lover.index')->with('success', 'Lover updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lover = Lover::findOrFail($id);

        if ($lover->avatar) {
            Storage::disk('public')->delete($lover->avatar);
        }

        $lover->delete();

        return redirect()->route('lover.index')->with('success', 'Lover deleted successfully.');
    }

    /**
     * Add memory to the specified lover.
     */
    public function addMemory(Request $request, string $id)
    {
        $lover = Lover::findOrFail($id);

        $validatedData = $request->validate([
            'memory' => 'required|json',
        ]);

        $existingMemory = json_decode($lover->memory, true) ?? [];
        $newMemory = json_decode($validatedData['memory'], true);

        $lover->memory = json_encode(array_merge($existingMemory, $newMemory));
        $lover->save();

        return redirect()->route('lover.index')->with('success', 'Memory added successfully.');
    }

    /**
     * Display memory images of the specified lover.
     */
    public function memory(string $id)
    {
        $lover = Lover::findOrFail($id);
        $memoryImages = $lover->memories; // Lấy danh sách memories từ bảng memories
        return view('lovers.memory', compact('lover', 'memoryImages'));
    }

    /**
     * Add memory image to the specified lover.
     */
    public function addMemoryImage(Request $request, string $id)
    {
        $lover = Lover::findOrFail($id);

        // Kiểm tra số lượng ảnh hiện tại
        if ($lover->memories()->count() >= 9) {
            return redirect()->route('lover.memory', $lover->id)
                ->withErrors('Each lover can only have up to 9 images.');
        }

        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Save image to Cloudinary
        $path = $this->saveToCloudinary($request->file('image'));

        // Create memory record with Cloudinary URL
        Memory::create([
            'lover_id' => $lover->id,
            'image_url' => $path,
        ]);

        return redirect()->route('lover.memory', $lover->id)->with('success', 'Image added successfully.');
    }

    /**
     * Delete memory image from the specified lover.
     */
    public function deleteMemoryImage(string $id, string $imageId)
    {
        $memory = Memory::findOrFail($imageId);

        // Ensure the correct disk name is used
        Storage::disk('cloudinary')->delete($memory->image_url);
        $memory->delete();

        return redirect()->route('lover.memory', $id)->with('success', 'Image deleted successfully.');
    }

    /**
     * Save a file to Cloudinary.
     */
    private function saveToCloudinary($file)
    {
        // Ensure the correct disk name is used
        $uploadedFileUrl = Storage::disk('cloudinary')->putFile('avatar', $file);
        return $uploadedFileUrl;
    }
}
