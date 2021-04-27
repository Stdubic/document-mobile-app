<?php

namespace App\Http\Controllers;

use App\Http\Resources\SectionResource;
use App\Section;
use App\Sentence;
use App\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use stdClass as stdClass;


class ProcessDocumentAPIController extends Controller
{
    public function index(Request $request)
    {
        return $request;
    }

    public function store(Request $request){
        $data = json_decode($request->data);
        $document = $data[0];
        $document_id = $document->data->database->id;
        $content = $document->children;

        // =======================================================
        // ================ DELETE REMOVED NODES =================
        // =======================================================

        if($document_id != "-1"){

            $document_old = DB::table('documents')->select('id', 'title', 'structure')->where('id', $document_id)->first();

            $old_data = '[{
			"text": "'.$document_old->title.'",
		    "data": {
		        "database": {
		            "id": "'. $document_old->id .'",
		            "type": "DOCUMENT",
		            "document_title": "'. $document_old->title .'"
		        }
		    },
		    "children" : '.$document_old->structure .'
		}]';

            $old_data = json_decode($old_data);
            $new_data = $data;


            function getNodeId($node){
                $r =[];
                $push =new DocumentNode;
                $push->id = $node->data->database->id;
                $push->type = $node->data->database->type;
                array_push($r, $push);
                foreach ($node->children as $child) {
                    $r = array_merge($r, getNodeId($child));
                }
                return $r;
            }

            $old_id_arr = getNodeId($old_data[0]);
            $new_id_arr = getNodeId($new_data[0]);

            $to_delete = array_diff($old_id_arr, $new_id_arr);

            foreach ($to_delete as $node) {
                $id = $node->id;
                if($node->type == "SENTENCE") {
                    DB::table('sentences')->where('id', $id)->delete();
                } else if($node->type == "SECTION"){
                    DB::table('sections')->where('id', $id)->delete();
                }
            }
        }


        // =======================================================
        // ============= INSERT /UPDATE DOCUMENT =================
        // =======================================================

        if($document_id == "-1"){
            $new_doc = Document::create([
                "title" => $document->data->database->document_title,
                 "protected" => $document->data->database->protected
            ]);
            $document_id = $new_doc->id;
        } else {
            Document::findOrFail($document_id)->update([
                "title" => $document->data->database->document_title,
                "protected" => $document->data->database->protected
            ]);
        }

        foreach ($content as &$node) {
            $node = process_node($node, $document_id) ;
        }

        $structure = $content;

        $newDoc = Document::findOrFail($document_id)->update([
            "structure" =>  json_encode($structure)
        ]);

        return $document_id;

    }
}

class DocumentNode{
    public $id, $type;
    function __toString()
    {
        return "".$this->id;
    }
}


function process_node($node,$document_id){
    $new_node = new stdClass;
    $new_data = $node->data;
    // dd($node);
    if($node->data->database->type == 'IMAGE'){
        $new_node->data =  $node->data;
        $new_node->type = $node->type;
        $new_node->text = $node->text;
        $new_node->id = uniqid('id_',true);
        $new_node->children = [];
        return $new_node;
    }

    // update /create nodes ind DB
    switch ($new_data->database->type) {
        case 'SECTION':
            $new_section = Section::firstOrCreate(
                ['id'=>$node->data->database->id ],
                [
                    "document_id" => $document_id,
                    "section_title" => $node->data->database->section_title,
                    "description" => $node->data->database->section_description,
                    "section_number" => $node->data->database->section_number
                ]);
            $new_section->update(
                [
                    "document_id" => $document_id,
                    "section_title" => $node->data->database->section_title,
                    "description" => $node->data->database->section_description,
                    "section_number" => $node->data->database->section_number
                ]
            );
            $new_data->database->id = $new_section->id;
            break;
        case 'SENTENCE':
            $new_sentence = Sentence::firstOrCreate(
                ['id'=>$node->data->database->id ],
                [
                    "sentence_text" => $node->data->database->sentence_text,
                    "sentence_number" => $node->data->database->sentence_number
                ]
                );
            $new_sentence->update(
                [
                    "sentence_text" => $node->data->database->sentence_text,
                    "sentence_number" => $node->data->database->sentence_number
                ]
            );
            $new_data->database->id = $new_sentence->id;
            break;
    }


    $new_node->data = $new_data;
    // other info
    $new_node->type = $node->type;
    $new_node->text = $node->text;
    $new_node->id = uniqid('id_',true);
    $new_node->children = [];
    foreach ($node->children as $child_node) {
        array_push($new_node->children, process_node($child_node,$document_id));
    }
    return $new_node;
}
