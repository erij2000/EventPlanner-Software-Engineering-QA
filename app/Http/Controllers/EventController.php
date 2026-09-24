<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Admin: List all events in the dashboard table
     */
    public function index()
    {
        $events = Event::with('category')->get();
        return view('events.index', compact('events'));
    }

    /**
     * Admin: Show form to create a new event
     */
    public function create()
    {
        $categories = Category::all();
        return view('events.create', compact('categories'));
    }

    /**
     * Admin: Save a new event
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'place' => 'required',
            'capacity' => 'required|integer|min:1',
            'price' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id'
        ]);

        $data['created_by'] = Auth::id();
        $data['is_free'] = empty($request->price) || $request->price == 0;

        Event::create($data);

        // Fixed: Added admin. prefix
        return redirect()->route('admin.events.index')->with('success', 'Event created successfully!');
    }

    /**
     * Admin: Show form to edit an existing event
     */
    public function edit(Event $event)
    {
        $categories = Category::all();
        return view('events.edit', compact('event', 'categories'));
    }

    /**
     * Admin: Update an existing event
     */
    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'place' => 'required',
            'capacity' => 'required|integer|min:1',
            'price' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id'
        ]);

        $data['is_free'] = empty($request->price) || $request->price == 0;

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully!');
    }

    /**
     * Admin: Delete an event
     */
    public function destroy(Event $event)
    {
        $event->delete();
        
        // Fixed: Added admin. prefix
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully!');
    }

    /**
     * Public: List events for users (The grid view)
     */
    public function publicIndex(Request $request)
    {
        // Change 'status' to whatever column you use for visibility, 
        // or remove the where() if you want to show all.
        $query = Event::with('category');

        // Filter by category
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // Search by title
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events = $query->paginate(6); 
        $categories = Category::all();

        // Ensure this view file exists: resources/views/events/public_index.blade.php
        return view('events.public_index', compact('events', 'categories'));
    }

    /**
     * Public: Detail page for a single event
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }
}