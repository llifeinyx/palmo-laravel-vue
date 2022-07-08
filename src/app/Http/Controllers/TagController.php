<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;

class TagController extends Controller
{
    public function index()
    {
        return Tag::all()->toArray();
    }
}
