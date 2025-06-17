<?php

namespace App\Http\Controllers\dev;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DevOperationController extends Controller
{
    public function runSQL(Request $request)
    {
        $request->validate([
            'sql' => 'required|string'
        ]);
        $sqlQuery = $request->input('sql');
        $queryType = strtoupper(strtok($sqlQuery, ' '));
        try {
            if ($queryType === 'SELECT') {
                $result = DB::select($sqlQuery);
                return response()->json($result);
            } else {
                $result = DB::statement($sqlQuery);
                return response()->json(['success' => $result]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function index()
    {
        $files = File::files('./../DOC');
        rsort($files);
        return view('dev.doc.index', compact(['files']));
    }

    public function getContent($file)
    {
        $files = File::files('./../DOC');
        rsort($files);
        $content = File::get('./../DOC/' . $file);
        return view('dev.doc.content', compact(['files', 'content']));
    }

    public function command(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "command" => "required",
        ]);
        if ($validator->fails())
            return $this->respondValidationErrors("Validation Error", $validator->errors(), 400);
        $output = '';
        if (!chdir('..')) {
            $consoleResult[] = "Error changing directory";
            return $consoleResult;
        }
        getcwd();
        exec($req->command, $output, $returnCode);
        return $output;
    }

    function getLogFileList()
    {
        $files = File::files('./../storage/logs');
        rsort($files);
        return view('dev.logs.index', compact(['files']));
    }
    function getLogFileContent($file)
    {
        $files = File::files('./../storage/logs');
        rsort($files);
        $content = File::get('./../storage/logs/' . $file);
        return view('dev.logs.content', compact(['files', 'content']));
    }
}





























