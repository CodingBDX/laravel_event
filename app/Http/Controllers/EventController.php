<?php

namespace App\Http\Controllers;

use auth;
use App\Models\Tag;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'only' => ['create', 'store']
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = event::where('starts_at', '>', now())->with(['user', 'tags'])->orderBy('starts_at','asc')->get();

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $authed_user = auth()->user();
$amount = 1000;

if($request->filled('premium')) $amount += 500;



     $authed_user->charge(
        $amount, $request->payment_method
    );

       $event = $authed_user->events()->create([
'title' => $request->title,
'content' => $request->content,
'premium' => $request->filled('premium'),
'starts_at' => $request->starts_at,
'ends_at' => $request->endss_at,
'slug' => Str::slug($request->title)
    ]);
    $tags = explode(',', $request->tags);

    foreach ($tags as $inputTag) {        $inputTag = trim($inputTag);

        $tag = Tag::firstOrCreate([
'slug' => Str::slug($inputTag)
        ], [
            'name' => $inputTag
        ]);

        $event->tags()->attach($tag->id);
    }
return redirect()->route('event.index');

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
