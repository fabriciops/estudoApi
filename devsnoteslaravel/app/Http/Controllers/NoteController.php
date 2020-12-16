<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    private $array = ['erro'=>'', 'result'=>[]];

    public function getAllnotes(){

        $notes = Note::all();

        // if(!$notes){
        //     return "Não há registros";
        // }

        foreach($notes as $note){
            $this->array['result'][] = [
                'id' => $note->id,
                'title' => $note->title,
            ];
        }


        return $this->array;

    }

    public function getOneNote($id){

        $note = Note::find($id);

        if($note){
            $this->array['result'] = $note;

        }else{
            $this->array['error'] = 'ID não encontrado';
        }

        return $this->array;

    }

    public function postNote(Request $request){

        $title = $request->input('title');
        $body = $request->input('body');

        if($title && $body){

            $note = new Note();
            $note->title = $title;
            $note->body = $body;
            $note->save();

            $this->array['result'] = [
                'id'=> $note->id,
                'title'=> $note->title,
                'body'=> $note->body,
            ];

        }else{

            $this->array['erro'] = 'Campos não enviados';
        }

        return $this->array;
    }

    public function editNote(Request $request, $id){

        $title = $request->input('title');
        $body = $request->input('body');

        if($title && $body){

            $note = Note::find($id);
            
            if($note){

                $note->title = $title;
                $note->body = $body;
                $note->save();

                $this->array['result']=[
                    'id' => $id,
                    'title' => $title,
                    'body' => $body
                ];


            } else{

                $this->array['erro'] = 'ID não existente';
            }

        }else{

            $this->array['erro'] = 'Campos não enviados';
        }

        return $this->array;
    }

    public function deletetNote($id){
        
        $note = Note::find($id);

        if($note){
            $note->delete();

        }else{

            $this->array['erro'] = 'ID inexistente';
        }

        return $this->array;

    }

}
