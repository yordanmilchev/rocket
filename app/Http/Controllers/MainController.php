<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use App\Models\Skill;
use App\Models\Uni;
use http\Env\Response;
use Illuminate\Http\Request;

class MainController extends Controller
{
    function createcv()
    {
        $data = ['Unis'=>Uni::all(), 'Skills'=>Skill::all()];
        return view('createcv', $data);
    }

    function showrecords()
    {
        return view('fetchcv');
    }

    function createdbrecord(Request $request)
    {
        $request->validate([
            'ime' => 'required|min:2',
            'prezime' => 'required|min:2',
            'familiq' => 'required|min:2',
            'dateofbirth' => 'required',
            'uni' => 'required',
            'skills' => 'required'
        ]);

        $userInfo = Cv::where('ime', $request->ime)->get();
        if ($userInfo) {
            foreach ($userInfo as $user) {
                if ($user->familiq == $request->familiq && $user->dob == $request->dateofbirth) {
                    return back()->with('fail', 'Този потребител вече съществува');
                }
            }
        }

        $cv = new Cv;
        $cv->ime = $request->ime;
        $cv->prezime = $request->prezime;
        $cv->familiq = $request->familiq;
        $cv->dob = date('y-m-d',strtotime($request->dateofbirth));
        $cv->uni = $request->uni;
        $skills='';
        foreach ($request->skills as $skill)
            {
                $skills.=$skill."/";
            }
        $cv->skills = $skills;
        $cv->save();

        return back()->with('success', 'Успешно вписване');
    }

    function adduni(Request $request)
    {
        $check = Uni::where('name', $request->nameuni)->first();
        if ($check) {
            $data = 'Университета е бил добавен вече';
            return response()->json($data);
        } else {

            $uni = new Uni;
            $uni->name = $request->nameuni;
            $uni->ocenka = $request->ocenka;
            $uni->save();

            return response()->json($uni);
        }
    }

    function addskill(Request $request)
    {
        $check = Skill::where('name', $request->nameskill)->first();
        if ($check) {
            $data = 'Технологията е била добавена вече';
            return response()->json($data);
        } else {

            $skill = new Skill;
            $skill->name = $request->nameskill;
            $skill->save();

            return response()->json($skill);
        }
    }

    function fetchcv(Request $request)
    {
        $query = Cv::query();
        if(isset($request->from)){
            $query->where('dob', '>=', $request->from);
        }if(isset($request->to)){
            $query->where('dob', '<=', $request->to);
        }
        return response()->json(['success' => true, 'cvs' => $query->get()]);
    }
}
