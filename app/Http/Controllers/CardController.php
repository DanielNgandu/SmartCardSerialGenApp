<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Jobs\SyncMedia;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $cards = Card::all();

        return view('card.index', compact('cards'));
    }

    /**
     * @param \App\Http\Requests\PostStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostStoreRequest $request)
    {
        $card = Card::create($request->validated());

//        Mail::to($card->author->email)->send(new ReviewPost($post));

        SyncMedia::dispatch($card);

        event(new NewCard($card));

        $request->session()->flash('card.title', $card->id);

        return redirect()->route('card.index');
    }
}
