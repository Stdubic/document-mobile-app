<?php

namespace App\Http\Controllers;

use App\Document;
use App\Role;
use App\Section;
use App\Sentence;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSentence;
use App\Http\Requests\MultiValues;
use Validator;
use Illuminate\Support\Facades\DB;

class SentenceBackendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sentences = Sentence::orderBy('text')->get();

        return view('sentences.list', compact('sentences'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $documents = Document::all();
        return view('sentences.add',compact('documents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSentence $request)
    {

        $validator = Validator::make($request->all(), [
            'section_id' => [
                'required',
                'max:255',
                function($attribute, $value, $fail) {
                    // info o sectionu
                    $section_details = DB::table('sections')
                                         ->select(DB::raw('sections.id as id, 
                                            sections.title as title, 
                                            COUNT(sentences.id) as number_of_sentences,
                                            COUNT(subsection.id) as number_of_subsections'))
                                         ->leftJoin('sections as subsection', 'subsection.parent_section_id', '=', 'sections.id')
                                         ->leftJoin('sentences', 'sentences.section_id' ,'=', 'sections.id')
                                         ->where('sections.id', '=', $value)
                                         ->groupBy('sections.id')
                                         ->groupBy('sections.title')
                                         ->first();

                    $section_details = (array)$section_details;

                    if (  $section_details['number_of_subsections'] != 0 ) {
                        return $fail($attribute.' is invalid.');
                    }
                },
            ]
        ]);

        if ($validator->fails()) {
            return redirect('sentences/add')
                ->withErrors($validator)
                ->withInput();
        }

        Sentence::create([
            'section_id' => $request->section_id,
            'text' => $request->text,
        ]);

        return redirect(route('sentences.list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sentence
     * @return \Illuminate\Http\Response
     */
    public function show(Sentence $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sentence
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $documents = Document::all();
        $sentence = Sentence::findOrFail($id);
        $section = Section::where('id', $sentence->section_id)
                           ->get();

        return view('sentences.add', compact('sentence','section','documents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sentence
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSentence $request, $id)
    {
        Sentence::findOrFail($id)->update([
            'text' => $request->text,
        ]);

        return redirect(route('sentences.list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sentence
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Sentence::findOrFail($id)->delete();

        return $this->index();
    }

    public function multiRemove(MultiValues $request)
    {
        $values = $request->values;

        foreach($values as $id) Sentence::find($id)->delete();

        return back();
    }

}
