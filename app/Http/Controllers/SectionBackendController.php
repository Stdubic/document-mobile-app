<?php

namespace App\Http\Controllers;

use App\Document;
use App\Http\Requests\StoreSection;
use App\Role;
use App\Section;
use App\Sentence;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDocument;
use App\Http\Requests\MultiValues;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SectionBackendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$sections_category = Section::findOrFail(59);
        //$sections_category = $sections_category->children()->get();
        //$sections_category = $sections_category->parent()->get();
        $sections = Section::with('document','children','sentences')->orderBy('title')->get();


        return view('sections.list', compact('sections','sections_category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $documents = Document::all();
        return view('sections.add', compact('documents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSection $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_section_id' => [
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

                    if (  $section_details['number_of_sentences'] != 0 ) {
                        return $fail($attribute.' is invalid.');
                    }
                },
            ]
        ]);

        if ($validator->fails()) {
            return redirect('sections/add')
                ->withErrors($validator)
                ->withInput();
        }

        Section::create([
            'document_id' => $request->document_id,
            'parent_section_id' => $request->parent_section_id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect(route('sections.list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Section
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Section
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $section = Section::with('document')->findOrFail($id);
        $documents = Document::all();
        $sentences = Sentence::all()->where('section_id', $section->id);
        $sectionid = $section->id;

        return view('sections.edit', compact('section','documents', 'sentences','sectionid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Section
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSection $request, $id)
    {
        Section::findOrFail($id)->update([
            'document_id' => 1,
            'sentence_id' => 1,
            'parent_sentance_id' => 1,
            'title' => $request->title,
            'description' => 'jjsdbjsbdjk',
        ]);

        return redirect(route('sections.list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Section
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Section::findOrFail($id)->delete();

        return $this->index();
    }

    public function multiRemove(MultiValues $request)
    {
        $values = $request->values;

        foreach($values as $id) Section::find($id)->delete();

        return back();
    }
    public function addMore()
    {
        return view("addMore");
    }


    public function addMorePost(Request $request)
    {
        $rules = [];


        foreach($request->input('name') as $key => $value) {
            $rules["name.{$key}"] = 'required';
        }


        $validator = Validator::make($request->all(), $rules);


        if ($validator->passes()) {

            $section =Section::create([
                'document_id' => $request->document,
                'sentence_id' => 1,
                'parent_sentance_id' => 1,
                'title' => $request->title,
                'description' => 'jjsdbjsbdjk',
            ]);


            foreach($request->input('name') as $key => $value) {
                Sentence::create(['section_id'=>$section->id,'title'=>$value]);
            }


            return response()->json(['success'=>'done']);
        }


        return response()->json(['error'=>$validator->errors()->all()]);
    }

}
