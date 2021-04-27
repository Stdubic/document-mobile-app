<?php


namespace App\Http\Controllers;


use App\Document;
use App\Section;
use App\Sentence;
use Illuminate\Http\Request;
use App\TagList;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
{
    public function index(){
        return view('home');
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