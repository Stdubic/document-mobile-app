<?php

namespace App\Http\Controllers;

use App\Http\Resources\SectionResource;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SectionsAPIController extends Controller
{
    public function index()
    {
        return SectionResource::collection(Section::all());
    }

    public function show(Section $section)
    {
        // u response_array je response koji ce bit arr koji ce bit JSON
        $response_array = null;
        // info o sectionu
        $section_details = DB::table('sections')
                             ->select(DB::raw('sections.id as id, 
                                            sections.title as title, 
                                            COUNT(sentences.id) as number_of_sentences,
                                            COUNT(subsection.id) as number_of_subsections'))
                             ->leftJoin('sections as subsection', 'subsection.parent_section_id', '=', 'sections.id')
                             ->leftJoin('sentences', 'sentences.section_id' ,'=', 'sections.id')
                             ->where('sections.id', '=', $section->id)
            ->groupBy('sections.id')
            ->groupBy('sections.title')
        ->first();
        $response_array = (array)$section_details;

        // subesctions od sectiona
        $subsections = DB::table('sections')
                            ->select(DB::raw('sections.id as id, 
		sections.title as title, 
		COUNT(sentences.id) as number_of_sentences,
		COUNT(subsection.id) as number_of_subsections'))
                            ->leftJoin('sections as subsection', 'subsection.parent_section_id', '=', 'sections.id')
                            ->leftJoin('sentences', 'sentences.section_id' ,'=', 'sections.id')
                            ->where('sections.parent_section_id', '=', $section->id)
                            ->groupBy('sections.id')
                            ->groupBy('sections.title');

        $response_array['subsections'] = $subsections->get();

        // path od sectiona
        function getSection($section_id){
            $temp_section = DB::table('sections')
                             ->where('sections.id', '=', $section_id);
            $response_object = $temp_section->first();
            return (array)$response_object;
        }

        $path = [];
        $security_counter = 0;
        $temp_section_id = $section->id;
        while( $temp_section_id != "0" ){
            $section_temp = getSection($temp_section_id);
            if($security_counter>100) break;
            $security_counter++;
            $path[] = $section_temp;
            $temp_section_id = $section_temp['parent_section_id'];
        }

        $response_array['path'] = $path;

        return $response_array;
    }
}
